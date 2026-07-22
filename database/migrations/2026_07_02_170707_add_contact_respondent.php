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
        //
        Schema::table('instrument_submission_v2', function (Blueprint $table) {
            $table->string('respondent_contact')->comment('Kontak responden')->nullable()->after('respondent_position');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('instrument_submission_v2', function (Blueprint $table) {
            $table->dropColumn('respondent_contact');
        });
    }
};
