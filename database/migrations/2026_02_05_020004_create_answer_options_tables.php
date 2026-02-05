<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Create a lookup table for standardized answer options
     * This allows reusable scales (e.g., Likert scales, rating scales)
     * across multiple questions
     */
    public function up(): void
    {
        Schema::create('answer_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('assessment_questions')->onDelete('cascade');

            // Option value (what gets stored in answer)
            $table->string('option_value', 100)
                ->comment('The value stored (e.g., 1, 2, 3, or "yes", "no")');

            // Option label (what user sees)
            $table->string('option_label')
                ->comment('Display label (e.g., "Sangat Tidak Sesuai", "Sesuai")');

            // Score associated with this option
            $table->decimal('score', 8, 2)->default(0.00)
                ->comment('Score value for this option');

            // Order for displaying options
            $table->unsignedInteger('order')->default(0);

            // Color coding for UI (optional)
            $table->string('color', 20)->nullable()
                ->comment('Color code for visual representation (e.g., red, yellow, green)');

            // Icon or emoji (optional)
            $table->string('icon', 50)->nullable();

            // Description or help text for this option
            $table->text('description')->nullable();

            // Active status
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            // Indexes
            $table->index(['question_id', 'order']);
            $table->index(['question_id', 'option_value']);
            $table->index('is_active');
        });

        // Create a table for predefined scale templates
        // These can be reused across multiple questions
        Schema::create('scale_templates', function (Blueprint $table) {
            $table->id();

            // Template identification
            $table->string('code', 50)->unique()
                ->comment('Unique code (e.g., LIKERT_5, RATING_1_10, YES_NO)');
            $table->string('name')
                ->comment('Template name (e.g., "5-Point Likert Scale")');
            $table->text('description')->nullable();

            // Scale configuration
            $table->enum('scale_type', [
                'likert',           // Likert scale (agreement)
                'rating',           // Numeric rating
                'frequency',        // Frequency scale
                'satisfaction',     // Satisfaction scale
                'quality',          // Quality assessment
                'boolean',          // Yes/No, True/False
                'custom'            // Custom scale
            ]);

            // JSON structure for scale options
            // Example: [{"value":1,"label":"Sangat Tidak Setuju","score":20},...]
            $table->json('scale_options')
                ->comment('Array of scale options with value, label, and score');

            // Scoring configuration
            $table->decimal('min_score', 8, 2)->default(0.00);
            $table->decimal('max_score', 8, 2)->default(100.00);

            // Usage tracking
            $table->unsignedInteger('usage_count')->default(0)
                ->comment('Number of questions using this template');

            // Status
            $table->boolean('is_default')->default(false)
                ->comment('Is this a default/system template');
            $table->boolean('is_active')->default(true);

            // Ownership
            $table->foreignId('created_by')->nullable()
                ->constrained('users')->onDelete('set null');

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('scale_type');
            $table->index(['is_active', 'is_default']);
            $table->index('code');
            $table->index('deleted_at');
        });

        // Link questions to scale templates (optional)
        Schema::table('assessment_questions', function (Blueprint $table) {
            $table->foreignId('scale_template_id')->nullable()
                ->after('answer_options')
                ->constrained('scale_templates')->onDelete('set null')
                ->comment('Link to predefined scale template');

            $table->index('scale_template_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove scale_template_id from assessment_questions
        Schema::table('assessment_questions', function (Blueprint $table) {
            $table->dropForeign(['scale_template_id']);
            $table->dropIndex(['scale_template_id']);
            $table->dropColumn('scale_template_id');
        });

        // Drop tables
        Schema::dropIfExists('scale_templates');
        Schema::dropIfExists('answer_options');
    }
};
