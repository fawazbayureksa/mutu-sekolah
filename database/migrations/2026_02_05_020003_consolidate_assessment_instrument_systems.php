<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * This migration consolidates the two systems:
     * 1. Assessment System (aspects -> indicators -> questions -> answers)
     * 2. Instrument System (instruments -> instrument_items -> responses)
     * 
     * Strategy: Make instrument_items reference assessment_questions
     * This allows instruments to be built from reusable question library
     */
    public function up(): void
    {
        // Add reference to assessment_questions in instrument_items
        Schema::table('instrument_items', function (Blueprint $table) {
            // Link to assessment_questions for unified question library
            $table->foreignId('assessment_question_id')->nullable()->after('instrument_id')
                ->constrained('assessment_questions')->onDelete('cascade')
                ->comment('Reference to master question library');

            // Keep section for grouping within instrument
            // indicator_code, indicator_text, answer_type become optional/deprecated
            // when assessment_question_id is present

            // Add order for question sequence within instrument
            $table->unsignedInteger('order')->default(0)->after('answer_type');

            // Flag to indicate if using master question or custom question
            $table->boolean('uses_master_question')->default(false)->after('order')
                ->comment('True if using assessment_question_id, false if custom');

            // Allow instrument-specific overrides
            $table->text('custom_help_text')->nullable()->after('uses_master_question')
                ->comment('Override help text for this specific instrument');
            $table->json('custom_answer_options')->nullable()->after('custom_help_text')
                ->comment('Override answer options for this specific instrument');

            // Make existing fields nullable when using master question
            $table->string('indicator_code')->nullable()->change();
            $table->text('indicator_text')->nullable()->change();
            $table->string('answer_type')->nullable()->change();

            // Indexes
            $table->index(['instrument_id', 'order']);
            $table->index('assessment_question_id');
            $table->index('uses_master_question');
        });

        // Add aspect and indicator references to instruments for categorization
        Schema::table('instruments', function (Blueprint $table) {
            // Categorize instruments by assessment aspects
            $table->string('category', 100)->nullable()->after('code')
                ->comment('Instrument category/type');

            // Version control for instruments
            $table->string('version', 20)->default('1.0')->after('description');
            $table->boolean('is_active')->default(true)->after('version');
            $table->boolean('is_published')->default(false)->after('is_active');
            $table->date('published_at')->nullable()->after('is_published');

            // Author/creator
            $table->foreignId('created_by')->nullable()->after('published_at')
                ->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->after('created_by')
                ->constrained('users')->onDelete('set null');

            // Metadata
            $table->text('instructions')->nullable()->after('description')
                ->comment('General instructions for filling this instrument');
            $table->unsignedInteger('estimated_duration')->nullable()->after('instructions')
                ->comment('Estimated time to complete in minutes');

            // Scoring configuration
            $table->enum('scoring_method', [
                'simple_sum',       // Sum all scores
                'weighted_sum',     // Sum with question weights
                'average',          // Average of all scores
                'percentage',       // Percentage of max score
                'custom'            // Custom calculation logic
            ])->default('weighted_sum')->after('estimated_duration');

            $table->softDeletes()->after('updated_at');

            // Indexes
            $table->index('category');
            $table->index(['is_active', 'is_published']);
            $table->index('version');
            $table->index('deleted_at');
        });

        // Bridge assessment_aspects with instruments (many-to-many)
        Schema::create('instrument_aspects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instrument_id')->constrained('instruments')->onDelete('cascade');
            $table->foreignId('aspect_id')->constrained('assessment_aspects')->onDelete('cascade');
            $table->unsignedInteger('order')->default(0);
            $table->decimal('weight', 5, 2)->default(1.00)
                ->comment('Weight of this aspect in the instrument');
            $table->timestamps();

            // Unique constraint to prevent duplicate aspect assignments
            $table->unique(['instrument_id', 'aspect_id']);
            $table->index(['instrument_id', 'order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the bridge table
        Schema::dropIfExists('instrument_aspects');

        // Revert instruments table changes
        Schema::table('instruments', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);

            $table->dropIndex(['category']);
            $table->dropIndex(['is_active', 'is_published']);
            $table->dropIndex(['version']);
            $table->dropIndex(['deleted_at']);

            $table->dropColumn([
                'category',
                'version',
                'is_active',
                'is_published',
                'published_at',
                'created_by',
                'updated_by',
                'instructions',
                'estimated_duration',
                'scoring_method',
                'deleted_at'
            ]);
        });

        // Revert instrument_items table changes
        Schema::table('instrument_items', function (Blueprint $table) {
            $table->dropForeign(['assessment_question_id']);

            $table->dropIndex(['instrument_id', 'order']);
            $table->dropIndex(['assessment_question_id']);
            $table->dropIndex(['uses_master_question']);

            $table->dropColumn([
                'assessment_question_id',
                'order',
                'uses_master_question',
                'custom_help_text',
                'custom_answer_options'
            ]);

            // Restore not null constraints
            $table->string('indicator_code')->nullable(false)->change();
            $table->text('indicator_text')->nullable(false)->change();
            $table->string('answer_type')->nullable(false)->change();
        });
    }
};
