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
        Schema::table('schools', function (Blueprint $table) {
            // Check and remove respondent-related fields as they now belong to submissions
            if (Schema::hasColumn('schools', 'respondent_name')) {
                $table->dropColumn('respondent_name');
            }
            if (Schema::hasColumn('schools', 'respondent_position')) {
                $table->dropColumn('respondent_position');
            }
            if (Schema::hasColumn('schools', 'filled_at')) {
                $table->dropColumn('filled_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            // Restore fields if migration is rolled back
            if (!Schema::hasColumn('schools', 'respondent_name')) {
                $table->string('respondent_name');
            }
            if (!Schema::hasColumn('schools', 'respondent_position')) {
                $table->string('respondent_position');
            }
            if (!Schema::hasColumn('schools', 'filled_at')) {
                $table->date('filled_at');
            }
        });
    }
};
