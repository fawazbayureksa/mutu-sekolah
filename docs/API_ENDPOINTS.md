<?php

use Illuminate\Http\Request;

return [
    'GET /api/instruments' => 'List all instruments with pagination',
    'POST /api/instruments' => 'Create a new instrument',
    'GET /api/instruments/{id}' => 'Get instrument details with aspects and questions',
    'PUT /api/instruments/{id}' => 'Update instrument',
    'DELETE /api/instruments/{id}' => 'Delete instrument',
    'POST /api/instruments/{id}/publish' => 'Publish instrument',
    'POST /api/instruments/{id}/unpublish' => 'Unpublish instrument',
    'POST /api/instruments/{id}/duplicate' => 'Duplicate instrument',
    
    'GET /api/questions' => 'List all questions with pagination',
    'POST /api/questions' => 'Create a new question',
    'GET /api/questions/{id}' => 'Get question details',
    'PUT /api/questions/{id}' => 'Update question',
    'DELETE /api/questions/{id}' => 'Delete question',
    
    'GET /api/scale-templates' => 'List all scale templates',
    'POST /api/scale-templates' => 'Create a new scale template',
    'GET /api/scale-templates/{id}' => 'Get scale template details',
    'PUT /api/scale-templates/{id}' => 'Update scale template',
    'DELETE /api/scale-templates/{id}' => 'Delete scale template',
    
    'GET /api/assessments' => 'List all assessments with pagination',
    'POST /api/assessments' => 'Create a new assessment',
    'GET /api/assessments/{id}' => 'Get assessment details with scores',
    'PUT /api/assessments/{id}' => 'Update assessment',
    'DELETE /api/assessments/{id}' => 'Delete assessment',
    'POST /api/assessments/{id}/submit' => 'Submit assessment',
    'POST /api/assessments/{id}/verify' => 'Verify assessment',
    'POST /api/assessments/{id}/approve' => 'Approve assessment',
    'POST /api/assessments/{id}/reject' => 'Reject assessment',
    'POST /api/assessments/{id}/recalculate-scores' => 'Recalculate assessment scores',
    
    'GET /api/assessments/{assessmentId}/answers' => 'List all answers for an assessment',
    'POST /api/assessments/{assessmentId}/answers' => 'Save an answer',
    'PUT /api/assessments/{assessmentId}/answers/{answerId}' => 'Update an answer',
    'DELETE /api/assessments/{assessmentId}/answers/{answerId}' => 'Delete an answer',
    'POST /api/assessments/{assessmentId}/answers/{answerId}/validate' => 'Validate an answer',
];
