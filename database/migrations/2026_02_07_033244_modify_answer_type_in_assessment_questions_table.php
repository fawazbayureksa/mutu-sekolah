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
        Schema::table('assessment_questions', function (Blueprint $table) {
            // Change enum to string to support more types like 'structure', 'number', etc.
            $table->string('answer_type')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assessment_questions', function (Blueprint $table) {
            // Revert back to enum (warning: data loss if values outside enum exist)
            // For safety in dev, we could leave it as string or try to convert back
            // $table->enum('answer_type', ['boolean', 'scale', 'text'])->change();
        });
    }
};
