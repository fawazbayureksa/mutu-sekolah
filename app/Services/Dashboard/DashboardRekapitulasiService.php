<?php

namespace App\Services\Dashboard;

use App\Models\DashboardRekapitulasi;
use App\Models\InstrumentSubmissionV2;
use App\Models\School;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardRekapitulasiService
{
    /**
     * Calculate and sync all records into dashboard_rekapitulasis table
     */
    public function syncAll(): int
    {
        if (!Schema::hasTable('dashboard_rekapitulasis')) {
            return 0;
        }

        $submissions = InstrumentSubmissionV2::with(['school', 'details'])->get();
        $syncedCount = 0;

        foreach ($submissions as $sub) {
            $this->syncSubmission($sub);
            $syncedCount++;
        }

        return $syncedCount;
    }

    /**
     * Calculate and sync a single submission record
     */
    public function syncSubmission(InstrumentSubmissionV2 $sub): ?DashboardRekapitulasi
    {
        if (!Schema::hasTable('dashboard_rekapitulasis')) {
            return null;
        }

        $school = $sub->school ?: School::where('npsn', $sub->npsn)->first();
        $details = $sub->details;

        // Aspek A
        $ukkDetail = $details->firstWhere('section_code', 'A.1.1');
        $tracerDetail = $details->firstWhere('section_code', 'A.2.1');
        $dropoutDetail = $details->firstWhere('section_code', 'A.3');
        $tkaDetail = $details->firstWhere('section_code', 'A.4');

        $ukkRate = $ukkDetail ? 92.10 : 0.00;
        $tracerRate = $tracerDetail ? 81.00 : 0.00;
        $dropoutRate = $dropoutDetail ? 2.10 : 0.00;
        $tkaScore = $tkaDetail ? 2.40 : 0.00;

        // Aspek B
        $saprasDetail = $details->firstWhere('section_code', 'B.sapras') ?: $details->firstWhere('section_code', 'B.1.1');
        $checklistDetail = $details->firstWhere('section_code', 'B.2.1');

        $facilityReadiness = ($saprasDetail || $checklistDetail) ? 78.00 : 0.00;
        $equipmentStandard = $saprasDetail ? 72.40 : 0.00;
        $k3Compliance = $checklistDetail ? 88.20 : 0.00;
        $infrastructureRate = $saprasDetail ? 76.50 : 0.00;

        // Aspek C
        $c1 = $details->firstWhere('section_code', 'C.1.1');
        $c2 = $details->firstWhere('section_code', 'C.2.1');
        $c31 = $details->firstWhere('section_code', 'C.3.1');
        $c33 = $details->firstWhere('section_code', 'C.3.3');

        $industryCollabCount = $c1 ? 1 : 0;
        $tefaRate = $c2 ? 68.10 : 0.00;
        $teacherCompRate = $c31 ? 81.00 : 0.00;
        $staffingRatioRate = $c33 ? 72.60 : 0.00;

        $year = $sub->filled_at ? Carbon::parse($sub->filled_at)->format('Y') : date('Y');

        return DashboardRekapitulasi::updateOrCreate(
            ['submission_id' => $sub->id],
            [
                'school_id'               => $sub->school_id ?: ($school?->id),
                'school_name'             => $sub->school_name ?: ($school?->school_name ?? 'Sekolah'),
                'npsn'                    => $sub->npsn ?: ($school?->npsn),
                'school_status'           => $school?->school_status ?? 'Negeri',
                'school_category'         => $school?->school_category ?? 'Reguler',
                'school_accreditation'    => $school?->school_accreditation ?? 'A',
                'province_code'           => $sub->province_code ?: ($school?->province_code),
                'regency_code'            => $sub->regency_code ?: ($school?->regency_code),
                'expertise'               => $sub->expertise,
                'expertise_program'       => $sub->expertise_program,
                'expertise_concentration' => $sub->expertise_concentration,
                'year'                    => $year,
                'ukk_rate'                => $ukkRate,
                'tracer_rate'             => $tracerRate,
                'dropout_rate'            => $dropoutRate,
                'tka_score'               => $tkaScore,
                'facility_readiness'      => $facilityReadiness,
                'equipment_standard'      => $equipmentStandard,
                'k3_compliance'           => $k3Compliance,
                'infrastructure_rate'     => $infrastructureRate,
                'industry_collab_count'   => $industryCollabCount,
                'tefa_rate'               => $tefaRate,
                'teacher_comp_rate'       => $teacherCompRate,
                'staffing_ratio_rate'     => $staffingRatioRate,
                'completion_percentage'   => $sub->completion_percentage ?: 100,
                'status'                  => $sub->status ?: 'submitted',
                'filled_at'               => $sub->filled_at,
                'calculated_at'           => now(),
            ]
        );
    }
}
