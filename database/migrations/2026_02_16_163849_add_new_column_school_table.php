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
            //
            $table->string('school_status', 20)->comment('Swasta / Negeri')->nullable();
            $table->string('school_category', 50)->comment('SMK PK Reguler / SMK PK Penguatan Pembelajaran Mendalam / SMK Model')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->dropColumn('school_status');
            $table->dropColumn('school_category');
        });
    }
};
