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
        Schema::table('assessment_questions', function (Blueprint $table) {
            // Add question code for easier reference (e.g., A.1.1, B.2.1)
            $table->string('question_code', 20)->nullable()->after('id')->unique();

            // Standardize answer types and add more options
            $table->enum('answer_type', [
                'boolean',      // Yes/No, Ada/Tidak Ada
                'scale',        // 1-5 rating scale
                'number',       // Numeric input
                'text',         // Free text/descriptive
                'multiple_choice', // Pilihan ganda
                'percentage',   // Percentage value
                'file'          // File upload
            ])->change();

            // Store answer options as JSON for scale, multiple_choice types
            // Example: {"min":1,"max":5,"labels":{"1":"Sangat Tidak Sesuai","5":"Sangat Sesuai"}}
            // Or: [{"value":"a","label":"Option A"},{"value":"b","label":"Option B"}]
            $table->json('answer_options')->nullable()->after('answer_type');

            // Help text or guidance for answering the question
            $table->text('help_text')->nullable()->after('answer_options');

            // Mark if question is required
            $table->boolean('is_required')->default(true)->after('help_text');

            // Scoring configuration
            $table->decimal('max_score', 8, 2)->default(100.00)->after('weight');
            $table->decimal('min_score', 8, 2)->default(0.00)->after('max_score');

            // Additional metadata
            $table->boolean('is_active')->default(true)->after('order');

            // Index for better performance
            $table->index('question_code');
            $table->index(['indicator_id', 'order']);
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assessment_questions', function (Blueprint $table) {
            // Drop indexes
            $table->dropIndex(['question_code']);
            $table->dropIndex(['indicator_id', 'order']);
            $table->dropIndex(['is_active']);

            // Drop added columns
            $table->dropColumn([
                'question_code',
                'answer_options',
                'help_text',
                'is_required',
                'max_score',
                'min_score',
                'is_active'
            ]);

            // Revert answer_type enum to original
            $table->enum('answer_type', ['boolean', 'scale', 'text'])->change();
        });
    }
};
