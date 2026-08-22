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
            $table->boolean('has_sop')->default(false)->after('staffing_ratio_rate')->index();
            $table->boolean('is_below_ideal_ratio')->default(true)->after('has_sop')->index();
            $table->boolean('is_tracer_incomplete')->default(true)->after('is_below_ideal_ratio')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dashboard_rekapitulasis', function (Blueprint $table) {
            $table->dropIndex(['has_sop']);
            $table->dropIndex(['is_below_ideal_ratio']);
            $table->dropIndex(['is_tracer_incomplete']);
            $table->dropColumn(['has_sop', 'is_below_ideal_ratio', 'is_tracer_incomplete']);
        });
    }
};
