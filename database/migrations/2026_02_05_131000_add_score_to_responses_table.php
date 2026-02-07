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
        Schema::table('responses', function (Blueprint $table) {
            // Add score column for storing calculated score based on scale template
            $table->decimal('score', 8, 2)->nullable()->after('answer');
        });

        // Add score columns to submissions table if not exists
        if (!Schema::hasColumn('submissions', 'total_score')) {
            Schema::table('submissions', function (Blueprint $table) {
                $table->decimal('total_score', 10, 2)->nullable()->after('status');
                $table->decimal('max_possible_score', 10, 2)->nullable()->after('total_score');
                $table->decimal('completion_percentage', 5, 2)->nullable()->after('max_possible_score');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('responses', function (Blueprint $table) {
            $table->dropColumn('score');
        });

        if (Schema::hasColumn('submissions', 'total_score')) {
            Schema::table('submissions', function (Blueprint $table) {
                $table->dropColumn(['total_score', 'max_possible_score', 'completion_percentage']);
            });
        }
    }
};
