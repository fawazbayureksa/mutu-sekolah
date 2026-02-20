<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('instrument_submissions_v2', function (Blueprint $table) {
            $table->string('province_code')->nullable()->after('address');
            $table->string('regency_code')->nullable()->after('province_code');
        });
    }

    public function down(): void
    {
        Schema::table('instrument_submissions_v2', function (Blueprint $table) {
            $table->dropColumn(['province_code', 'regency_code']);
        });
    }
};
