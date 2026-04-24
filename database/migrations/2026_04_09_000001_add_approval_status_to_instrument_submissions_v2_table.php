<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('instrument_submissions_v2', function (Blueprint $table) {
            $table->string('approval_status', 20)->nullable()->after('curriculum')
                ->comment('Sudah / Belum (only for Kemaritiman)');
        });
    }

    public function down(): void
    {
        Schema::table('instrument_submissions_v2', function (Blueprint $table) {
            $table->dropColumn('approval_status');
        });
    }
};
