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
        Schema::table('instruments', function (Blueprint $table) {
            // Check and add each column only if it doesn't exist
            if (!Schema::hasColumn('instruments', 'category')) {
                $table->string('category')->nullable()->after('description');
            }
            if (!Schema::hasColumn('instruments', 'version')) {
                $table->string('version')->default('1.0')->after('category');
            }
            if (!Schema::hasColumn('instruments', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('version');
            }
            if (!Schema::hasColumn('instruments', 'is_published')) {
                $table->boolean('is_published')->default(false)->after('is_active');
            }
            if (!Schema::hasColumn('instruments', 'published_at')) {
                $table->timestamp('published_at')->nullable()->after('is_published');
            }
            if (!Schema::hasColumn('instruments', 'created_by')) {
                $table->unsignedBigInteger('created_by')->nullable()->after('published_at');
            }
            if (!Schema::hasColumn('instruments', 'updated_by')) {
                $table->unsignedBigInteger('updated_by')->nullable()->after('created_by');
            }
            if (!Schema::hasColumn('instruments', 'instructions')) {
                $table->text('instructions')->nullable()->after('updated_by');
            }
            if (!Schema::hasColumn('instruments', 'estimated_duration')) {
                $table->integer('estimated_duration')->nullable()->comment('in minutes')->after('instructions');
            }
            if (!Schema::hasColumn('instruments', 'scoring_method')) {
                $table->string('scoring_method')->default('weighted_average')->after('estimated_duration');
            }
        });

        // Add foreign key constraints only if columns were added
        Schema::table('instruments', function (Blueprint $table) {
            if (Schema::hasColumn('instruments', 'created_by')) {
                $foreignKeys = Schema::getConnection()->getDoctrineSchemaManager()->listTableForeignKeys('instruments');
                $hasForeignKey = collect($foreignKeys)->contains(function ($key) {
                    return in_array('created_by', $key->getColumns());
                });

                if (!$hasForeignKey) {
                    $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
                }
            }

            if (Schema::hasColumn('instruments', 'updated_by')) {
                $foreignKeys = Schema::getConnection()->getDoctrineSchemaManager()->listTableForeignKeys('instruments');
                $hasForeignKey = collect($foreignKeys)->contains(function ($key) {
                    return in_array('updated_by', $key->getColumns());
                });

                if (!$hasForeignKey) {
                    $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('instruments', function (Blueprint $table) {
            // Drop foreign keys if they exist
            try {
                $foreignKeys = Schema::getConnection()->getDoctrineSchemaManager()->listTableForeignKeys('instruments');

                foreach ($foreignKeys as $foreignKey) {
                    if (in_array('created_by', $foreignKey->getColumns())) {
                        $table->dropForeign(['created_by']);
                    }
                    if (in_array('updated_by', $foreignKey->getColumns())) {
                        $table->dropForeign(['updated_by']);
                    }
                }
            } catch (\Exception $e) {
                // Foreign keys might not exist
            }

            // Drop columns if they exist
            $columnsToCheck = [
                'category',
                'version',
                'is_active',
                'is_published',
                'published_at',
                'created_by',
                'updated_by',
                'instructions',
                'estimated_duration',
                'scoring_method'
            ];

            $columnsToRemove = [];
            foreach ($columnsToCheck as $column) {
                if (Schema::hasColumn('instruments', $column)) {
                    $columnsToRemove[] = $column;
                }
            }

            if (!empty($columnsToRemove)) {
                $table->dropColumn($columnsToRemove);
            }
        });
    }
};
