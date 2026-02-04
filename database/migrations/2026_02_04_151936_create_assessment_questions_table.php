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
        Schema::create('assessment_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('indicator_id')->nullable();
            // $table->foreignId('indicator_id')->constrained('assessment_indicators')->onDelete('cascade');
            $table->text('question_text');
            $table->enum('answer_type', ['boolean', 'scale', 'text']);
            $table->decimal('weight', 5, 2)->default(1.00);
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_questions');
    }
};
