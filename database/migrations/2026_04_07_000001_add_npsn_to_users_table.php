<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('npsn', 20)->nullable()->unique()->after('email');
            $table->boolean('must_change_password')->default(false)->after('remember_token');
        });

        // Make email nullable to support school accounts that authenticate via NPSN only
        DB::statement('ALTER TABLE users MODIFY COLUMN email VARCHAR(255) NULL');
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['npsn']);
            $table->dropColumn(['npsn', 'must_change_password']);
        });

        DB::statement('ALTER TABLE users MODIFY COLUMN email VARCHAR(255) NOT NULL');
    }
};
