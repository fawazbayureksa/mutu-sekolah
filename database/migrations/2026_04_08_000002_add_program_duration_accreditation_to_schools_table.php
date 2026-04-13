<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->string('program_duration', 20)->nullable()->comment('3 Tahun / 4 Tahun')->after('school_category');
            $table->string('school_accreditation', 30)->nullable()->comment('A / B / C / Belum Terakreditasi')->after('program_duration');
        });
    }

    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->dropColumn(['program_duration', 'school_accreditation']);
        });
    }
};
