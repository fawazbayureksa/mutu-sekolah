<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InstrumentSubmissionV2;
use App\Models\Province;
use App\Models\Regency;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LaporanController extends Controller
{
    public function index(Request $request): View
    {
        $provinceCode = $request->get('province_code');
        $regencyCode  = $request->get('regency_code');
        $status       = $request->get('status');

        // Build base query for report grouping
        $query = InstrumentSubmissionV2::query()
            ->selectRaw('
                expertise,
                expertise_program,
                expertise_concentration,
                COUNT(DISTINCT COALESCE(npsn, CAST(id AS CHAR))) AS total_sekolah
            ')
            ->when($provinceCode, fn($q) => $q->where('province_code', $provinceCode))
            ->when($regencyCode,  fn($q) => $q->where('regency_code', $regencyCode))
            ->when($status,       fn($q) => $q->where('status', $status))
            ->whereNotNull('expertise')
            ->whereNotNull('expertise_program')
            ->whereNotNull('expertise_concentration')
            ->groupBy('expertise', 'expertise_program', 'expertise_concentration')
            ->orderBy('expertise')
            ->orderBy('expertise_program')
            ->orderBy('expertise_concentration')
            ->get();

        // Hierarchically group: expertise -> expertise_program -> [concentrations]
        $grouped = $query->groupBy('expertise')->map(function ($byExpertise) {
            return $byExpertise->groupBy('expertise_program')->map(function ($byProgram) {
                return $byProgram;
            });
        });

        // Summary stats
        $statsQuery = InstrumentSubmissionV2::query()
            ->when($provinceCode, fn($q) => $q->where('province_code', $provinceCode))
            ->when($regencyCode,  fn($q) => $q->where('regency_code', $regencyCode))
            ->when($status,       fn($q) => $q->where('status', $status));

        $stats = [
            'total_sekolah'     => (clone $statsQuery)->distinct('npsn')->count('npsn'),
            'total_bidang'      => (clone $statsQuery)->distinct('expertise')->count('expertise'),
            'total_program'     => (clone $statsQuery)->distinct('expertise_program')->count('expertise_program'),
            'total_konsentrasi' => (clone $statsQuery)->distinct('expertise_concentration')->count('expertise_concentration'),
        ];

        // Dropdown data
        $provinces = Province::orderBy('name')->get();
        $regencies = $provinceCode
            ? Regency::where('province_code', $provinceCode)->orderBy('name')->get()
            : collect();

        return view('admin.laporan.index', compact(
            'grouped',
            'stats',
            'provinces',
            'regencies',
            'provinceCode',
            'regencyCode',
            'status',
        ));
    }

    public function detail(Request $request): View
    {
        // Row-level filter params (passed from the Detail button)
        $expertise              = $request->get('expertise');
        $expertiseProgram       = $request->get('expertise_program');
        $expertiseConcentration = $request->get('expertise_concentration');

        // Carry-through global filters from the index page
        $provinceCode = $request->get('province_code');
        $regencyCode  = $request->get('regency_code');
        $status       = $request->get('status');

        $submissions = InstrumentSubmissionV2::query()
            ->with(['province', 'regency'])
            ->when($expertise,              fn($q) => $q->where('expertise', $expertise))
            ->when($expertiseProgram,       fn($q) => $q->where('expertise_program', $expertiseProgram))
            ->when($expertiseConcentration, fn($q) => $q->where('expertise_concentration', $expertiseConcentration))
            ->when($provinceCode,           fn($q) => $q->where('province_code', $provinceCode))
            ->when($regencyCode,            fn($q) => $q->where('regency_code', $regencyCode))
            ->when($status,                 fn($q) => $q->where('status', $status))
            ->orderBy('school_name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.laporan.detail', compact(
            'submissions',
            'expertise',
            'expertiseProgram',
            'expertiseConcentration',
            'provinceCode',
            'regencyCode',
            'status',
        ));
    }
}
