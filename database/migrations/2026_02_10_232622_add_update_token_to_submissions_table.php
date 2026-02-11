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
        Schema::table('submissions', function (Blueprint $table) {
            $table->string('update_token', 12)->nullable()->unique()->after('verification_notes');
            $table->timestamp('update_token_used_at')->nullable()->after('update_token');
            $table->timestamp('update_token_expires_at')->nullable()->after('update_token_used_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('submissions', function (Blueprint $table) {
            $table->dropColumn(['update_token', 'update_token_used_at', 'update_token_expires_at']);
        });
    }
};
