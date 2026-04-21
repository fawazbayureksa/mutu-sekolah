<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('instrument_submissions_v2', function (Blueprint $table) {
            $table->string('expertise')->nullable()->after('regency_code');
            $table->string('expertise_program')->nullable()->after('expertise');
            $table->string('expertise_concentration')->nullable()->after('expertise_program');
            $table->string('curriculum')->nullable()->after('expertise_concentration');
        });
    }

    public function down(): void
    {
        Schema::table('instrument_submissions_v2', function (Blueprint $table) {
            $table->dropColumn(['expertise', 'expertise_program', 'expertise_concentration', 'curriculum']);
        });
    }
};
