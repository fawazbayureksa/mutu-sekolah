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
        Schema::table('schools', function (Blueprint $table) {
            // Add address column
            $table->text('address')->nullable()->after('npsn');
        });

        // Migrate existing data: combine province and city into address
        DB::table('schools')->get()->each(function ($school) {
            $address = trim(($school->city ?? '') . ', ' . ($school->province ?? ''), ', ');
            DB::table('schools')
                ->where('id', $school->id)
                ->update(['address' => $address ?: null]);
        });

        Schema::table('schools', function (Blueprint $table) {
            // Make address required now that data is migrated
            $table->text('address')->nullable(false)->change();

            // Drop old columns
            $table->dropColumn(['province', 'city']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            // Add back province and city columns
            $table->string('province')->nullable()->after('npsn');
            $table->string('city')->nullable()->after('province');
        });

        // Try to parse address back into province and city (best effort)
        DB::table('schools')->get()->each(function ($school) {
            if ($school->address) {
                $parts = array_map('trim', explode(',', $school->address));
                $city = $parts[0] ?? '';
                $province = $parts[1] ?? '';

                DB::table('schools')
                    ->where('id', $school->id)
                    ->update([
                        'city' => $city ?: null,
                        'province' => $province ?: null,
                    ]);
            }
        });

        Schema::table('schools', function (Blueprint $table) {
            // Make province and city required
            $table->string('province')->nullable(false)->change();
            $table->string('city')->nullable(false)->change();

            // Drop address column
            $table->dropColumn('address');
        });
    }
};
