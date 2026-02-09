<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('submissions', function (Blueprint $table) {
            $table->dropForeign(['verified_by']);
        });

        Schema::table('submissions', function (Blueprint $table) {
            $table->dropColumn('validation_notes');
        });

        Schema::table('submissions', function (Blueprint $table) {
            $table->enum('status', ['draft', 'submitted', 'verified', 'validated', 'released', 'rejected'])
                ->default('submitted')
                ->change();

            $table->text('verification_notes')->nullable()->after('verified_at');

            $table->foreignId('validated_by')->nullable()->after('verification_notes');
            $table->timestamp('validated_at')->nullable()->after('validated_by');
            $table->text('validation_notes')->nullable()->after('validated_at');

            $table->foreignId('released_by')->nullable()->after('validation_notes');
            $table->timestamp('released_at')->nullable()->after('released_by');

            $table->foreign('verified_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('validated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('released_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('submissions', function (Blueprint $table) {
            $table->dropForeign(['validated_by']);
            $table->dropForeign(['released_by']);
        });

        Schema::table('submissions', function (Blueprint $table) {
            $table->dropColumn([
                'verification_notes',
                'validated_by',
                'validated_at',
                'validation_notes',
                'released_by',
                'released_at',
            ]);
        });

        Schema::table('submissions', function (Blueprint $table) {
            $table->text('validation_notes')->nullable()->after('verified_at');
        });

        Schema::table('submissions', function (Blueprint $table) {
            $table->enum('status', ['draft', 'submitted', 'verified', 'validated'])
                ->default('submitted')
                ->change();
        });
    }
};
