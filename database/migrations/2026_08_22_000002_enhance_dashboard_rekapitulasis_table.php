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
        Schema::table('dashboard_rekapitulasis', function (Blueprint $table) {
            // Aspek A.1.1 & A.1.2 detail counts
            $table->unsignedInteger('ukk_participants')->default(0)->after('ukk_rate');
            $table->unsignedInteger('ukk_passed')->default(0)->after('ukk_participants');
            $table->unsignedInteger('certification_count')->default(0)->after('ukk_passed');

            // Aspek A.2.1 detail counts
            $table->unsignedInteger('tracer_total_graduates')->default(0)->after('tracer_rate');
            $table->unsignedInteger('tracer_employed')->default(0)->after('tracer_total_graduates');
            $table->unsignedInteger('tracer_continuing_edu')->default(0)->after('tracer_employed');
            $table->unsignedInteger('tracer_entrepreneur')->default(0)->after('tracer_continuing_edu');

            // Aspek A.3 detail counts
            $table->unsignedInteger('dropout_initial')->default(0)->after('dropout_rate');
            $table->unsignedInteger('dropout_final')->default(0)->after('dropout_initial');
            $table->unsignedInteger('dropout_count')->default(0)->after('dropout_final');

            // Aspek A.4 detail averages
            $table->decimal('tka_school_avg', 5, 2)->default(0)->after('tka_score');
            $table->decimal('tka_national_avg', 5, 2)->default(0)->after('tka_school_avg');

            // Aspek C detail counts
            $table->unsignedInteger('industry_partner_count')->default(0)->after('industry_collab_count');
            $table->string('tefa_category', 100)->nullable()->after('tefa_rate');
            $table->unsignedInteger('teacher_trained_count')->default(0)->after('teacher_comp_rate');

            // Versioning and calculation tracking
            $table->unsignedSmallInteger('projection_version')->default(1)->after('calculated_at');

            // Ensure unique submission_id constraint (prevent duplicates on DB level)
            $table->unique('submission_id', 'dashboard_rekap_submission_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dashboard_rekapitulasis', function (Blueprint $table) {
            $table->dropUnique('dashboard_rekap_submission_unique');
            $table->dropColumn([
                'ukk_participants',
                'ukk_passed',
                'certification_count',
                'tracer_total_graduates',
                'tracer_employed',
                'tracer_continuing_edu',
                'tracer_entrepreneur',
                'dropout_initial',
                'dropout_final',
                'dropout_count',
                'tka_school_avg',
                'tka_national_avg',
                'industry_partner_count',
                'tefa_category',
                'teacher_trained_count',
                'projection_version',
            ]);
        });
    }
};
