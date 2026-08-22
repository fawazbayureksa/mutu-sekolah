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
        Schema::create('dashboard_rekapitulasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->nullable()->index();
            $table->foreignId('school_id')->nullable()->index();
            $table->string('school_name');
            $table->string('npsn', 30)->nullable()->index();
            $table->string('school_status', 50)->nullable()->index(); // Negeri, Swasta
            $table->string('school_category', 50)->nullable(); // PK, Non-PK, dll
            $table->string('school_accreditation', 10)->nullable(); // A, B, C, TT

            // Wilayah
            $table->string('province_code', 10)->nullable()->index();
            $table->string('regency_code', 10)->nullable()->index();

            // Struktur Kejuruan
            $table->string('expertise')->nullable()->index();
            $table->string('expertise_program')->nullable()->index();
            $table->string('expertise_concentration')->nullable()->index();
            $table->string('year', 20)->nullable()->index(); // e.g. 2025/2026

            // Aspek A: Mutu Peserta Didik (%)
            $table->decimal('ukk_rate', 5, 2)->default(0);
            $table->decimal('tracer_rate', 5, 2)->default(0);
            $table->decimal('dropout_rate', 5, 2)->default(0);
            $table->decimal('tka_score', 5, 2)->default(0);

            // Aspek B: Sarana Prasarana (%)
            $table->decimal('facility_readiness', 5, 2)->default(0);
            $table->decimal('equipment_standard', 5, 2)->default(0);
            $table->decimal('k3_compliance', 5, 2)->default(0);
            $table->decimal('infrastructure_rate', 5, 2)->default(0);

            // Aspek C: Tata Kelola
            $table->integer('industry_collab_count')->default(0);
            $table->decimal('tefa_rate', 5, 2)->default(0);
            $table->decimal('teacher_comp_rate', 5, 2)->default(0);
            $table->decimal('staffing_ratio_rate', 5, 2)->default(0);

            // General Status & Progress
            $table->decimal('completion_percentage', 5, 2)->default(0);
            $table->string('status', 50)->default('draft')->index();
            $table->date('filled_at')->nullable();
            $table->timestamp('calculated_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dashboard_rekapitulasis');
    }
};
