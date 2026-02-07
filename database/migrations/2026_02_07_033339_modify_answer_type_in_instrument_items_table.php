<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Fix inconsistent state
        Schema::table('instrument_items', function (Blueprint $table) {
            if (Schema::hasColumn('instrument_items', 'answer_type_new')) {
                $table->dropColumn('answer_type_new');
            }
            if (Schema::hasColumn('instrument_items', 'answer_type')) {
                $table->dropColumn('answer_type');
            }
        });

        Schema::table('instrument_items', function (Blueprint $table) {
            $table->string('answer_type')->after('indicator_text');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
