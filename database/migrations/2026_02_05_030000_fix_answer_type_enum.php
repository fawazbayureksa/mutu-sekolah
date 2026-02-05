<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE assessment_questions MODIFY COLUMN answer_type ENUM('boolean', 'scale', 'number', 'text', 'multiple_choice', 'percentage', 'file', 'option') NOT NULL");

        DB::table('assessment_questions')
            ->where('answer_type', 'option')
            ->update(['answer_type' => 'multiple_choice']);

        if (Schema::hasTable('instrument_items') && Schema::hasColumn('instrument_items', 'answer_type')) {
            DB::statement("ALTER TABLE instrument_items MODIFY COLUMN answer_type ENUM('boolean', 'scale', 'number', 'text', 'multiple_choice', 'percentage', 'file', 'option')");

            DB::table('instrument_items')
                ->where('answer_type', 'option')
                ->update(['answer_type' => 'multiple_choice']);
        }
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE assessment_questions MODIFY COLUMN answer_type ENUM('boolean', 'scale', 'number', 'text', 'multiple_choice', 'percentage', 'file', 'option') NOT NULL");

        if (Schema::hasTable('instrument_items') && Schema::hasColumn('instrument_items', 'answer_type')) {
            DB::statement("ALTER TABLE instrument_items MODIFY COLUMN answer_type ENUM('boolean', 'scale', 'number', 'text', 'multiple_choice', 'percentage', 'file', 'option')");
        }
    }
};
