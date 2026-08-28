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
        Schema::create('dashboard_projection_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->nullable()->constrained('instrument_submissions_v2')->onDelete('cascade');
            $table->string('triggered_by', 50)->default('event'); // 'event', 'command', 'schedule', 'manual'
            $table->string('status', 30)->default('processing');  // 'processing', 'completed', 'failed'
            $table->text('message')->nullable();
            $table->decimal('duration_ms', 8, 2)->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index(['submission_id', 'status']);
            $table->index(['status', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dashboard_projection_logs');
    }
};
