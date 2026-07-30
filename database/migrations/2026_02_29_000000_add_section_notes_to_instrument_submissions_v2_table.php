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
        Schema::table('instrument_submissions_v2', function (Blueprint $table) {
            if (!Schema::hasColumn('instrument_submissions_v2', 'section_notes')) {
                $table->json('section_notes')->nullable()->after('answers');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('instrument_submissions_v2', function (Blueprint $table) {
            if (Schema::hasColumn('instrument_submissions_v2', 'section_notes')) {
                $table->dropColumn('section_notes');
            }
        });
    }
};
