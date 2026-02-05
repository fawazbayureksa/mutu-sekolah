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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->boolean('is_active')->default(true)->after('remember_token');
            $table->timestamp('last_login_at')->nullable()->after('is_active');
            $table->text('bio')->nullable()->after('last_login_at');
            $table->string('role')->default('user')->after('bio');

            $table->index(['is_active', 'role']);
            $table->index('last_login_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['is_active', 'role']);
            $table->dropIndex('last_login_at');
            $table->dropColumn(['phone', 'is_active', 'last_login_at', 'bio', 'role']);
        });
    }
};
