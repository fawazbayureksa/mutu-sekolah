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
        Schema::table('assessments', function (Blueprint $table) {
            // Link to instruments table for unified approach
            $table->foreignId('instrument_id')->nullable()->after('id')
                ->constrained('instruments')->onDelete('cascade');

            // Scoring fields
            $table->decimal('total_score', 10, 2)->nullable()->after('status');
            $table->decimal('max_possible_score', 10, 2)->nullable()->after('total_score');
            $table->decimal('percentage', 5, 2)->nullable()->after('max_possible_score')
                ->comment('Percentage score (0-100)');

            // Grade or category based on score
            $table->string('grade', 5)->nullable()->after('percentage')
                ->comment('e.g., A, B, C, or Grade 1-5');

            // Assessment metadata
            $table->string('academic_year', 20)->nullable()->after('period_year')
                ->comment('e.g., 2024/2025');
            $table->enum('semester', ['1', '2'])->nullable()->after('academic_year');

            // Assessment type/category
            $table->string('assessment_type', 50)->nullable()->after('semester')
                ->comment('e.g., self-assessment, external-audit, monitoring');

            // Completion tracking
            $table->unsignedInteger('total_questions')->default(0)->after('assessment_type');
            $table->unsignedInteger('answered_questions')->default(0)->after('total_questions');
            $table->decimal('completion_percentage', 5, 2)->default(0.00)->after('answered_questions');

            // Time tracking
            $table->timestamp('started_at')->nullable()->after('completion_percentage');
            $table->timestamp('completed_at')->nullable()->after('started_at');
            $table->unsignedInteger('duration_minutes')->nullable()->after('completed_at')
                ->comment('Time taken to complete in minutes');

            // Verification/validation workflow
            $table->foreignId('verified_by')->nullable()->after('submitted_at')
                ->constrained('users')->onDelete('set null');
            $table->timestamp('verified_at')->nullable()->after('verified_by');
            $table->text('verification_notes')->nullable()->after('verified_at');

            $table->foreignId('approved_by')->nullable()->after('verification_notes')
                ->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable()->after('approved_by');
            $table->text('approval_notes')->nullable()->after('approved_at');

            // Additional metadata
            $table->text('remarks')->nullable()->after('approval_notes')
                ->comment('General remarks or observations');
            $table->json('metadata')->nullable()->after('remarks')
                ->comment('Additional flexible metadata');

            // Soft deletes for data retention
            $table->softDeletes()->after('updated_at');

            // Indexes for performance
            $table->index('instrument_id');
            $table->index(['school_id', 'period_year']);
            $table->index(['status', 'submitted_at']);
            $table->index('academic_year');
            $table->index('assessment_type');
            $table->index('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assessments', function (Blueprint $table) {
            // Drop foreign keys
            $table->dropForeign(['instrument_id']);
            $table->dropForeign(['verified_by']);
            $table->dropForeign(['approved_by']);

            // Drop indexes
            $table->dropIndex(['instrument_id']);
            $table->dropIndex(['school_id', 'period_year']);
            $table->dropIndex(['status', 'submitted_at']);
            $table->dropIndex(['academic_year']);
            $table->dropIndex(['assessment_type']);
            $table->dropIndex(['deleted_at']);

            // Drop columns
            $table->dropColumn([
                'instrument_id',
                'total_score',
                'max_possible_score',
                'percentage',
                'grade',
                'academic_year',
                'semester',
                'assessment_type',
                'total_questions',
                'answered_questions',
                'completion_percentage',
                'started_at',
                'completed_at',
                'duration_minutes',
                'verified_by',
                'verified_at',
                'verification_notes',
                'approved_by',
                'approved_at',
                'approval_notes',
                'remarks',
                'metadata',
                'deleted_at'
            ]);
        });
    }
};
