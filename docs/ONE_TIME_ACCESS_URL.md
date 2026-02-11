# One-Time Access URL for Submission Updates

## Overview
This feature allows verifiers to generate secure, one-time access URLs that enable respondents to update their submission data without requiring authentication. This is particularly useful when a submission is rejected and needs corrections.

## Feature Details

### Key Characteristics
- **Short Token**: 8-character alphanumeric token (e.g., `A3K9B2X7`)
- **One-Time Use**: Token becomes invalid after being used once
- **Time-Limited**: Tokens expire after 7 days
- **No Authentication Required**: Respondents can access the form directly via the URL
- **Pre-filled Data**: Form is pre-populated with existing submission data
- **Verification Notes Displayed**: Rejection/verification notes are prominently shown

### Security Features
1. **Cryptographically Secure**: Uses PHP's `random_int()` for token generation
2. **Unique Tokens**: Database uniqueness constraint prevents duplicates
3. **Expiration Check**: Tokens are validated for expiration before access
4. **Usage Tracking**: System records when a token is used
5. **One-Time Validation**: Once used, token cannot be reused

## Database Schema

### New Fields in `submissions` Table
```php
$table->string('update_token', 12)->nullable()->unique();
$table->timestamp('update_token_used_at')->nullable();
$table->timestamp('update_token_expires_at')->nullable();
```

## Usage Workflow

### 1. Verifier Rejects Submission
When a verifier reviews a submission and finds issues:
1. Navigate to submission detail page
2. Click "Tolak" (Reject) button
3. Enter rejection notes explaining what needs to be corrected
4. Submit rejection

### 2. Generate Update Link
After rejection:
1. Go to the submission detail page or list
2. Click "Generate Link" button
3. System generates a unique token
4. URL is displayed in a modal with copy button
5. Share the URL with the respondent via email, WhatsApp, etc.

Example URL format:
```
https://example.com/submission/update/A3K9B2X7
```

### 3. Respondent Updates Data
When respondent clicks the link:
1. System validates the token (expiration, usage)
2. Form is displayed with:
   - Verification notes prominently shown
   - All existing data pre-filled
   - Read-only school and respondent information
   - Editable instrument responses
3. Respondent makes corrections
4. Submit updated data
5. Token is marked as used
6. Submission status returns to "submitted" for re-verification

## Code Structure

### Models
**`app/Models/Submission.php`**
- `generateUpdateToken()`: Creates a secure random token
- `isUpdateTokenValid()`: Validates token expiration and usage status
- `markTokenAsUsed()`: Records token usage timestamp

### Controllers
**`app/Http/Controllers/SubmissionUpdateController.php`**
- `show($token)`: Displays the update form with pre-filled data
- `update($token, Request)`: Processes the updated submission

**`app/Http/Controllers/Verifier/VerifierSubmissionController.php`**
- `generateUpdateToken($submission)`: Generates token for rejected submissions

### Routes
```php
// Public routes (no authentication required)
Route::get('/submission/update/{token}', [SubmissionUpdateController::class, 'show'])
    ->name('submission.update.show');
Route::post('/submission/update/{token}', [SubmissionUpdateController::class, 'update'])
    ->name('submission.update.store');

// Verifier routes (authentication required)
Route::post('/submissions/{submission}/generate-token', [VerifierSubmissionController::class, 'generateUpdateToken'])
    ->name('verifier.submissions.generate-token');
```

### Views
- `resources/views/submission/update.blade.php`: Update form with pre-filled data
- `resources/views/verifier/submissions/index.blade.php`: List with generate link buttons
- `resources/views/verifier/submissions/show.blade.php`: Detail with token display

## API Response Examples

### Token Generation Response
When generating a token, the system:
1. Creates token in database
2. Sets expiration to 7 days from now
3. Resets usage timestamp
4. Returns success message with URL

### Token Validation
Token is considered valid when:
- Token exists in database
- `update_token_used_at` is NULL
- `update_token_expires_at` is in the future

Token is invalid when:
- Token not found
- Already used (`update_token_used_at` is set)
- Expired (`update_token_expires_at` is in the past)

## Error Handling

### Common Errors
1. **Token Not Found**: HTTP 404 - Invalid or non-existent token
2. **Token Expired**: HTTP 403 - "Link sudah tidak berlaku atau sudah digunakan"
3. **Token Already Used**: HTTP 403 - "Link sudah tidak berlaku atau sudah digunakan"

## Best Practices

### For Verifiers
1. Always include clear, specific notes when rejecting submissions
2. Generate token immediately after rejection
3. Send the link to respondent through secure channels
4. Keep track of shared links
5. Regenerate token if needed (old token becomes invalid)

### For Developers
1. Always validate token before processing updates
2. Use database transactions when updating submission data
3. Log token generation and usage for audit trails
4. Consider adding rate limiting to prevent abuse
5. Monitor for patterns of token generation/usage

## Future Enhancements

Potential improvements for this feature:
1. Email notification with auto-generated link
2. Token regeneration limit (prevent spam)
3. Partial updates (only update changed fields)
4. Change tracking (show what was modified)
5. Multiple revision rounds support
6. Token analytics dashboard

## Testing

### Manual Testing Steps
1. Create a submission as respondent
2. Login as verifier
3. Reject the submission with notes
4. Generate update link
5. Copy and visit the link (in incognito/private window)
6. Verify form is pre-filled
7. Verify notes are displayed
8. Make changes and submit
9. Try to use the same link again (should fail)
10. Wait 7 days and try again (should expire)

### Security Testing
1. Try to guess tokens (should be difficult with 8 characters)
2. Try to reuse tokens (should fail)
3. Try to use expired tokens (should fail)
4. Check token uniqueness in database
5. Verify no authentication bypass

## Migration Instructions

To enable this feature on an existing installation:

```bash
# Run the migration
php artisan migrate

# Clear cache
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Support & Troubleshooting

### Token Not Generating
- Check database permissions
- Verify `submissions` table has new columns
- Check for migration errors

### Token Not Working
- Verify token exists in database
- Check expiration date
- Confirm token hasn't been used
- Clear route cache: `php artisan route:cache`

### Form Not Pre-filling
- Check responses exist for submission
- Verify JSON encoding for structure-type answers
- Check browser console for JavaScript errors

## Related Files
- Migration: `database/migrations/2026_02_10_232622_add_update_token_to_submissions_table.php`
- Model: `app/Models/Submission.php`
- Controller: `app/Http/Controllers/SubmissionUpdateController.php`
- Routes: `routes/web.php`
- Views: `resources/views/submission/update.blade.php`
