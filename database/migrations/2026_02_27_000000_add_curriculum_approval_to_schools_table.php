<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->string('curriculum', 50)->nullable()->comment('K13 / Kurikulum Merdeka');
            $table->string('approval_status', 20)->nullable()->comment('Sudah / Belum (only for Kemaritiman)');
        });
    }

    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->dropColumn(['curriculum', 'approval_status']);
        });
    }
};
