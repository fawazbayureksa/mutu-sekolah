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
        Schema::table('responses', function (Blueprint $table) {
            // Add submission_id to link responses to specific submissions
            $table->foreignId('submission_id')->after('id')->constrained('submissions')->onDelete('cascade');

            // Keep school_id for direct queries but make it nullable
            // We can populate it from submissions.school_id
            $table->unsignedBigInteger('school_id')->nullable()->change();

            // Add index for faster queries
            $table->index('submission_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('responses', function (Blueprint $table) {
            // Remove the foreign key and column
            $table->dropForeign(['submission_id']);
            $table->dropColumn('submission_id');

            // Restore school_id as not nullable
            $table->unsignedBigInteger('school_id')->nullable(false)->change();
        });
    }
};
