<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Main submission table for v2 instrument (hardcoded form)
        Schema::create('instrument_submissions_v2', function (Blueprint $table) {
            $table->id();

            // School Information
            $table->string('school_name');
            $table->string('npsn')->nullable();
            $table->text('address');

            // Respondent Information
            $table->string('respondent_name');
            $table->string('respondent_position');

            // Form Version (for future compatibility)
            $table->string('form_version')->default('2.0');

            // All form answers stored as JSON
            $table->json('answers')->nullable();

            // Status workflow
            $table->enum('status', ['draft', 'submitted', 'verified', 'validated', 'rejected'])->default('submitted');

            // Verification workflow
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('verified_at')->nullable();
            $table->text('verification_notes')->nullable();

            // Validation workflow
            $table->foreignId('validated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('validated_at')->nullable();
            $table->text('validation_notes')->nullable();

            // Update token for allowing edits
            $table->string('update_token')->nullable()->unique();
            $table->timestamp('update_token_used_at')->nullable();
            $table->timestamp('update_token_expires_at')->nullable();

            // Analytics & scoring
            $table->decimal('total_score', 8, 2)->nullable();
            $table->decimal('max_possible_score', 8, 2)->nullable();
            $table->decimal('completion_percentage', 5, 2)->nullable();

            // Metadata
            $table->date('filled_at');
            $table->ipAddress('ip_address')->nullable();
            $table->text('user_agent')->nullable();

            $table->timestamps();

            // Indexes for analytics queries
            $table->index('school_name');
            $table->index('npsn');
            $table->index('status');
            $table->index('filled_at');
            $table->index('form_version');
        });

        // Section details table for granular analytics
        Schema::create('instrument_submission_v2_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained('instrument_submissions_v2')->onDelete('cascade');

            // Section identifier (e.g., 'A.1.1', 'B.1.1', 'C.1.1', etc.)
            $table->string('section_code', 20);

            // Section data stored as JSON
            $table->json('data')->nullable();

            // Row count for dynamic tables (for analytics)
            $table->unsignedInteger('row_count')->default(0);

            // Optional score for this section
            $table->decimal('section_score', 8, 2)->nullable();

            $table->timestamps();

            // Index for quick section lookups (shortened name to avoid MySQL limit)
            $table->index(['submission_id', 'section_code'], 'v2_details_sub_section_idx');
            $table->index('section_code', 'v2_details_section_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instrument_submission_v2_details');
        Schema::dropIfExists('instrument_submissions_v2');
    }
};
