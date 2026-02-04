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
        Schema::create('assessment_indicators', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('aspect_id')->nullable();
            // $table->foreignId('aspect_id')->constrained('assessment_aspects')->onDelete('cascade');
            $table->string('code')->unique();
            $table->text('description');
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_indicators');
    }
};
