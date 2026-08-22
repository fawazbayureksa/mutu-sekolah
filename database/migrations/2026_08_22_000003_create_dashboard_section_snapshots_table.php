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
        Schema::create('dashboard_section_snapshots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained('instrument_submissions_v2')->onDelete('cascade');
            $table->foreignId('school_id')->nullable()->constrained('schools')->onDelete('set null');
            
            // Section code: 'A.1.1', 'A.1.2', 'A.2.1', 'A.3', 'A.4', 'B.sapras', 'B.2.1', 'C.1.1', 'C.2.1', 'C.3.1', 'C.3.2', 'C.3.3'
            $table->string('section_code', 20);
            
            // Filter / Context hierarchy
            $table->string('year', 20)->nullable(); // e.g. '2025/2026'
            $table->string('province_code', 10)->nullable();
            $table->string('regency_code', 10)->nullable();
            $table->string('expertise', 255)->nullable();
            $table->string('expertise_program', 255)->nullable();
            $table->string('expertise_concentration', 255)->nullable();

            // Computed scalar metrics for fast aggregation
            $table->decimal('metric_rate_1', 5, 2)->nullable(); // e.g. pass rate, compliance %, readiness %
            $table->decimal('metric_rate_2', 5, 2)->nullable();
            $table->unsignedInteger('metric_int_1')->nullable(); // e.g. participants count, partner count, teacher count
            $table->unsignedInteger('metric_int_2')->nullable(); // e.g. passed count, etc.
            $table->unsignedInteger('metric_int_3')->nullable();
            $table->boolean('metric_bool_1')->nullable();       // e.g. has_sop, is_compliant
            $table->boolean('metric_bool_2')->nullable();

            // Pre-parsed & normalized JSON data (cleaned from form noise, ready for UI / export)
            $table->json('processed_data')->nullable();
            $table->unsignedInteger('row_count')->default(0);

            // Audit
            $table->timestamp('calculated_at')->nullable();
            $table->timestamps();

            // Composite indexes for rapid multi-dimensional dashboard filtering
            $table->unique(['submission_id', 'section_code'], 'snapshot_sub_section_unique');
            $table->index(['section_code', 'year'], 'snapshot_section_year_idx');
            $table->index(['province_code', 'section_code'], 'snapshot_prov_section_idx');
            $table->index(['regency_code', 'section_code'], 'snapshot_reg_section_idx');
            $table->index(['expertise', 'section_code'], 'snapshot_exp_section_idx');
            $table->index(['expertise_program', 'section_code'], 'snapshot_prog_section_idx');
            $table->index(['expertise_concentration', 'section_code'], 'snapshot_conc_section_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dashboard_section_snapshots');
    }
};
