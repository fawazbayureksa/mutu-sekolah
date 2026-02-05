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
        Schema::table('assessment_answers', function (Blueprint $table) {
            // Add calculated score based on answer and question weight
            $table->decimal('score', 8, 2)->nullable()->after('answer_value');

            // Store raw answer value separately for better data type handling
            // answer_value remains as text for compatibility
            $table->decimal('numeric_value', 15, 4)->nullable()->after('score');
            $table->boolean('boolean_value')->nullable()->after('numeric_value');

            // Additional notes or comments for the answer
            $table->text('notes')->nullable()->after('boolean_value');

            // File path for file upload type answers
            $table->string('file_path')->nullable()->after('notes');

            // Evidence or supporting documents
            $table->json('attachments')->nullable()->after('file_path')
                ->comment('Array of file paths for supporting documents');

            // Track who provided the answer (useful for multi-respondent scenarios)
            $table->string('answered_by')->nullable()->after('attachments');
            $table->timestamp('answered_at')->nullable()->after('answered_by');

            // Validation status
            $table->enum('validation_status', [
                'pending',
                'validated',
                'rejected',
                'needs_revision'
            ])->default('pending')->after('answered_at');

            $table->text('validation_notes')->nullable()->after('validation_status');
            $table->foreignId('validated_by')->nullable()->after('validation_notes')
                ->constrained('users')->onDelete('set null');
            $table->timestamp('validated_at')->nullable()->after('validated_by');

            // Indexes for performance
            $table->index(['assessment_id', 'question_id']);
            $table->index('validation_status');
            $table->index('answered_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assessment_answers', function (Blueprint $table) {
            // Drop foreign key
            $table->dropForeign(['validated_by']);

            // Drop indexes
            $table->dropIndex(['assessment_id', 'question_id']);
            $table->dropIndex(['validation_status']);
            $table->dropIndex(['answered_at']);

            // Drop columns
            $table->dropColumn([
                'score',
                'numeric_value',
                'boolean_value',
                'notes',
                'file_path',
                'attachments',
                'answered_by',
                'answered_at',
                'validation_status',
                'validation_notes',
                'validated_by',
                'validated_at'
            ]);
        });
    }
};
