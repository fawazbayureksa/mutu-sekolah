<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add performance indexes to key lookup columns.
     * These indexes improve query performance for commonly filtered/joined fields.
     */
    public function up(): void
    {
        // Schools table: used heavily in search and joins
        Schema::table('schools', function (Blueprint $table) {
            if (! $this->indexExists('schools', 'schools_npsn_index')) {
                $table->index('npsn', 'schools_npsn_index');
            }
            if (! $this->indexExists('schools', 'schools_province_code_index')) {
                $table->index('province_code', 'schools_province_code_index');
            }
            if (! $this->indexExists('schools', 'schools_regency_code_index')) {
                $table->index('regency_code', 'schools_regency_code_index');
            }
        });

        // Submissions (V1) table: status and token lookups
        Schema::table('submissions', function (Blueprint $table) {
            if (! $this->indexExists('submissions', 'submissions_status_index')) {
                $table->index('status', 'submissions_status_index');
            }
            if (! $this->indexExists('submissions', 'submissions_update_token_index')) {
                $table->index('update_token', 'submissions_update_token_index');
            }
        });

        // Instrument submissions V2: status and token lookups
        // Note: school_name, npsn, status, filled_at, form_version indexes already exist
        // from the original migration. We add province/regency and token indexes here.
        Schema::table('instrument_submissions_v2', function (Blueprint $table) {
            if (! $this->indexExists('instrument_submissions_v2', 'isv2_province_code_index')) {
                $table->index('province_code', 'isv2_province_code_index');
            }
            if (! $this->indexExists('instrument_submissions_v2', 'isv2_regency_code_index')) {
                $table->index('regency_code', 'isv2_regency_code_index');
            }
            if (! $this->indexExists('instrument_submissions_v2', 'isv2_update_token_index')) {
                $table->index('update_token', 'isv2_update_token_index');
            }
        });

        // Assessments: status lookups and date range queries
        Schema::table('assessments', function (Blueprint $table) {
            if (! $this->indexExists('assessments', 'assessments_status_index')) {
                $table->index('status', 'assessments_status_index');
            }
            if (! $this->indexExists('assessments', 'assessments_assessment_date_index')) {
                $table->index('assessment_date', 'assessments_assessment_date_index');
            }
        });

        // Activity logs: lookups by user or action type
        Schema::table('activity_logs', function (Blueprint $table) {
            if (! $this->indexExists('activity_logs', 'activity_logs_user_id_index')) {
                $table->index('user_id', 'activity_logs_user_id_index');
            }
            if (! $this->indexExists('activity_logs', 'activity_logs_action_index')) {
                $table->index('action', 'activity_logs_action_index');
            }
        });
    }

    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            if ($this->indexExists('schools', 'schools_npsn_index')) {
                $table->dropIndex('schools_npsn_index');
            }
            if ($this->indexExists('schools', 'schools_province_code_index')) {
                $table->dropIndex('schools_province_code_index');
            }
            if ($this->indexExists('schools', 'schools_regency_code_index')) {
                $table->dropIndex('schools_regency_code_index');
            }
        });

        Schema::table('submissions', function (Blueprint $table) {
            if ($this->indexExists('submissions', 'submissions_status_index')) {
                $table->dropIndex('submissions_status_index');
            }
            if ($this->indexExists('submissions', 'submissions_update_token_index')) {
                $table->dropIndex('submissions_update_token_index');
            }
        });

        Schema::table('instrument_submissions_v2', function (Blueprint $table) {
            if ($this->indexExists('instrument_submissions_v2', 'isv2_province_code_index')) {
                $table->dropIndex('isv2_province_code_index');
            }
            if ($this->indexExists('instrument_submissions_v2', 'isv2_regency_code_index')) {
                $table->dropIndex('isv2_regency_code_index');
            }
            if ($this->indexExists('instrument_submissions_v2', 'isv2_update_token_index')) {
                $table->dropIndex('isv2_update_token_index');
            }
        });

        Schema::table('assessments', function (Blueprint $table) {
            if ($this->indexExists('assessments', 'assessments_status_index')) {
                $table->dropIndex('assessments_status_index');
            }
            if ($this->indexExists('assessments', 'assessments_assessment_date_index')) {
                $table->dropIndex('assessments_assessment_date_index');
            }
        });

        Schema::table('activity_logs', function (Blueprint $table) {
            if ($this->indexExists('activity_logs', 'activity_logs_user_id_index')) {
                $table->dropIndex('activity_logs_user_id_index');
            }
            if ($this->indexExists('activity_logs', 'activity_logs_action_index')) {
                $table->dropIndex('activity_logs_action_index');
            }
        });
    }

    /**
     * Check if an index already exists on a table to avoid duplicate index errors.
     */
    protected function indexExists(string $table, string $indexName): bool
    {
        $connection = Schema::getConnection();
        $dbName = $connection->getDatabaseName();

        return (bool) $connection->table('information_schema.statistics')
            ->where('table_schema', $dbName)
            ->where('table_name', $table)
            ->where('index_name', $indexName)
            ->exists();
    }
};
