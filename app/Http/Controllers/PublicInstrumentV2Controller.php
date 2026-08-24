<?php

namespace App\Http\Controllers;

use App\Models\InstrumentSubmissionV2;
use App\Models\InstrumentSubmissionV2Detail;
use App\Models\Province;
use App\Models\Regency;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PublicInstrumentV2Controller extends Controller
{
    public function index()
    {
        $provinces = Province::orderBy('name')->get();
        $respondentPositions = config('constant.respondent_positions');
        $expertiseData = config('constant.expertise');
        $expertiseByCurriculum = config('constant.expertise_by_curriculum');

        $schoolDefaults = null;
        if (auth()->check() && auth()->user()->role === 'school') {
            $schoolDefaults = auth()->user()->school;
        }

        return view('instrument.form-v2', compact('provinces', 'respondentPositions', 'expertiseData', 'expertiseByCurriculum', 'schoolDefaults'));
    }

    public function getRegencies($provinceCode)
    {
        // Cache static regency data for 24 hours to avoid repeated DB hits
        $regencies = Cache::remember("regencies:{$provinceCode}", 86400, function () use ($provinceCode) {
            return Regency::where('province_code', $provinceCode)
                ->orderBy('name')
                ->get(['code', 'name']);
        });

        return response()->json($regencies);
    }

    public function getSaprasData($concentration)
    {
        $saprasData = config('sapras_data');
        $concentration = urldecode($concentration);

        // Normalize: try exact match first, then underscore-replaced key, then case-insensitive
        if (!isset($saprasData[$concentration])) {
            $underscoredKey = str_replace(' ', '_', $concentration);
            if (isset($saprasData[$underscoredKey])) {
                $concentration = $underscoredKey;
            } else {
                // Case-insensitive fallback: find a matching key
                $loweredKey = strtolower($underscoredKey);
                $foundKey = null;
                foreach (array_keys($saprasData) as $key) {
                    if (strtolower($key) === $loweredKey) {
                        $foundKey = $key;
                        break;
                    }
                }
                if ($foundKey) {
                    $concentration = $foundKey;
                } else {
                    return response()->json(['sections' => []], 200);
                }
            }
        }

        return response()->json($saprasData[$concentration]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // Basic fields
            'school_name'           => 'required|string|max:255',
            'npsn'                  => 'required',
            'address'               => 'required|string|max:1000',

            // Validated against actual DB values
            'province_code'         => ['required', 'string', 'exists:provinces,code'],
            'regency_code'          => ['required', 'string', 'exists:regencies,code'],

            // Enum whitelist validation — only accept known values
            'school_status'         => ['required', Rule::in(['Negeri', 'Swasta'])],
            'school_category'       => ['required', Rule::in(array_keys(config('constant.school_category')))],
            'program_duration'      => ['required', Rule::in(['3 Tahun', '4 Tahun'])],
            'school_accreditation'  => ['required', Rule::in(config('constant.school_accreditation'))],
            'curriculum'            => ['required', Rule::in(config('constant.curriculum'))],
            'approval_status'       => ['nullable', 'required_if:expertise,Kemaritiman', Rule::in(config('constant.approval_status'))],
            'expertise'             => 'required|string|max:255',
            'expertise_program'     => 'required|string|max:255',
            'expertise_concentration' => 'required|string|max:255',

            'respondent_name'       => 'required|string|max:255',
            'respondent_position'   => ['required', 'string', Rule::in(config('constant.respondent_positions'))],
            'respondent_contact'    => 'nullable|string|max:255',
            // Limit array depth/size to prevent payload bombs
            'answers'               => 'required|array|max:20',
            'answers.*.rows'        => 'sometimes|array|max:200',
        ], [
            'school_name.required'       => 'Nama sekolah wajib diisi',
            'npsn.required'              => 'NPSN wajib diisi',
            'address.required'           => 'Alamat sekolah wajib diisi',
            'province_code.required'     => 'Provinsi wajib dipilih',
            'province_code.exists'       => 'Provinsi yang dipilih tidak valid',
            'regency_code.required'      => 'Kabupaten/Kota wajib dipilih',
            'regency_code.exists'        => 'Kabupaten/Kota yang dipilih tidak valid',
            'school_status.required'     => 'Status sekolah wajib dipilih',
            'school_category.required'   => 'Kategori sekolah wajib dipilih',
            'program_duration.required'  => 'Durasi program wajib dipilih',
            'school_accreditation.required' => 'Akreditasi sekolah wajib dipilih',
            'curriculum.required'        => 'Kurikulum wajib dipilih',
            'approval_status.required_if' => 'Status approval wajib dipilih untuk bidang Kemaritiman',
            'expertise.required'         => 'Bidang keahlian wajib dipilih',
            'expertise_program.required' => 'Program keahlian wajib dipilih',
            'expertise_concentration.required' => 'Konsentrasi keahlian wajib dipilih',
            'respondent_name.required'   => 'Nama responden wajib diisi',
            'respondent_position.required' => 'Jabatan responden wajib diisi',
            'respondent_position.in'     => 'Jabatan responden tidak valid',
            'answers.required'           => 'Data instrumen wajib diisi',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            // When a school user is authenticated, always use their linked school
            // to prevent school_id mismatches between submissions and the dashboard.
            // (A lookup by NPSN could return a different/unlinked School record.)
            if (auth()->check() && auth()->user()->role === 'school') {
                $school = auth()->user()->school;

                if (! $school) {
                    // Link the first unlinked school with this NPSN (same logic as getSchool())
                    $school = School::where('npsn', auth()->user()->npsn)
                        ->whereNull('user_id')
                        ->first();

                    if ($school) {
                        $school->update(['user_id' => auth()->user()->id]);
                        $school = $school->fresh();
                    } else {
                        $school = School::create([
                            'user_id'                 => auth()->user()->id,
                            'school_name'             => $request->school_name,
                            'npsn'                    => $request->npsn ?? auth()->user()->npsn,
                            'address'                 => $request->address,
                            'province_code'           => $request->province_code,
                            'regency_code'            => $request->regency_code,
                            'school_status'           => $request->school_status,
                            'school_category'         => $request->school_category,
                            'program_duration'        => $request->program_duration,
                            'school_accreditation'    => $request->school_accreditation,
                            'curriculum'              => $request->curriculum,
                            'approval_status'         => $request->approval_status,
                            'expertise'               => $request->expertise,
                            'expertise_program'       => $request->expertise_program,
                            'expertise_concentration' => $request->expertise_concentration,
                        ]);
                    }
                }

                // Always sync profile fields from the instrument form into the school record
                $school->update([
                    'school_name'             => $request->school_name,
                    'address'                 => $request->address,
                    'province_code'           => $request->province_code,
                    'regency_code'            => $request->regency_code,
                    'school_status'           => $request->school_status,
                    'school_category'         => $request->school_category,
                    'program_duration'        => $request->program_duration,
                    'school_accreditation'    => $request->school_accreditation,
                    'curriculum'              => $request->curriculum,
                    'approval_status'         => $request->approval_status,
                    'expertise'               => $request->expertise,
                    'expertise_program'       => $request->expertise_program,
                    'expertise_concentration' => $request->expertise_concentration,
                ]);
            } else {
                // Public (unauthenticated) submission — original lookup by NPSN / name+location
                $school = School::where(function ($q) use ($request) {
                    if ($request->npsn) {
                        $q->where('npsn', $request->npsn);
                    } else {
                        $q->where('school_name', $request->school_name)
                            ->where('province_code', $request->province_code)
                            ->where('regency_code', $request->regency_code);
                    }
                })->first();

                if (!$school) {
                    $school = School::create([
                        'school_name'             => $request->school_name,
                        'npsn'                    => $request->npsn ?? null,
                        'address'                 => $request->address,
                        'province_code'           => $request->province_code,
                        'regency_code'            => $request->regency_code,
                        'school_status'           => $request->school_status,
                        'school_category'         => $request->school_category,
                        'program_duration'        => $request->program_duration,
                        'school_accreditation'    => $request->school_accreditation,
                        'curriculum'              => $request->curriculum,
                        'approval_status'         => $request->approval_status,
                        'expertise'               => $request->expertise,
                        'expertise_program'       => $request->expertise_program,
                        'expertise_concentration' => $request->expertise_concentration,
                    ]);
                }
            }

            $submission = InstrumentSubmissionV2::create([
                'school_id'               => $school->id,
                'school_name'             => $request->school_name,
                'npsn'                    => $request->npsn ?? null,
                'address'                 => $request->address,
                'province_code'           => $request->province_code,
                'regency_code'            => $request->regency_code,
                'expertise'               => $request->expertise,
                'expertise_program'       => $request->expertise_program,
                'expertise_concentration' => $request->expertise_concentration,
                'curriculum'              => $request->curriculum,
                'respondent_name'         => $request->respondent_name,
                'respondent_position'     => $request->respondent_position,
                'respondent_contact'      => $request->respondent_contact,
                'form_version'            => '2.0',
                'answers'                 => $request->answers,
                'status'                  => InstrumentSubmissionV2::STATUS_SUBMITTED,
                'filled_at'               => now(),
                'ip_address'              => $request->ip(),
                'user_agent'              => $request->userAgent(),
            ]);

            $this->storeSectionDetails($submission, $request->answers);

            $submission->update([
                'completion_percentage' => $this->calculateCompletionPercentage($request->answers),
            ]);

            DB::commit();

            Log::info('V2 Instrument submission created', [
                'submission_id' => $submission->id,
                'school_name'   => $submission->school_name,
            ]);

            if (auth()->check() && auth()->user()->role === 'school') {
                return redirect()->route('school.submissions.index')
                    ->with('success', 'Pengajuan berhasil disimpan.');
            }

            return redirect()->route('landing')
                ->with('success', 'Data berhasil disimpan. Terima kasih atas partisipasi Anda.');
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('V2 Instrument submission error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return back()
                ->with('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.')
                ->withInput();
        }
    }

    private function storeSectionDetails(InstrumentSubmissionV2 $submission, array $answers): void
    {
        $sectionCodes = config('constant.section_codes');

        foreach ($sectionCodes as $code) {
            if (isset($answers[$code])) {
                // Answers are submitted as JSON strings from the form — decode before inspecting
                $data = is_string($answers[$code]) ? json_decode($answers[$code], true) : $answers[$code];
                $rowCount = 0;

                if (is_array($data)) {
                    if ($code === 'B.sapras') {
                        // B.sapras structure: { sections: [ { rows: [...] }, ... ] }
                        foreach ($data['sections'] ?? [] as $section) {
                            $rowCount += count($section['rows'] ?? []);
                        }
                    } elseif (isset($data['rows']) && is_array($data['rows'])) {
                        $rowCount = count($data['rows']);
                    } elseif (isset($data[0])) {
                        $rowCount = count($data);
                    }
                }

                InstrumentSubmissionV2Detail::create([
                    'submission_id' => $submission->id,
                    'section_code' => $code,
                    'data' => $data,
                    'row_count' => $rowCount,
                ]);
            }
        }
    }

    private function calculateCompletionPercentage(array $answers): float
    {
        $sectionCodes = config('constant.section_codes');
        $totalSections = count($sectionCodes);
        $filledSections = 0;

        foreach ($sectionCodes as $code) {
            if (! isset($answers[$code])) {
                continue;
            }

            // Answers are submitted as JSON strings from the form — decode before inspecting
            $data = is_string($answers[$code]) ? json_decode($answers[$code], true) : $answers[$code];

            if (empty($data) || ! is_array($data)) {
                continue;
            }

            if ($code === 'B.sapras') {
                // B.sapras is filled only if at least one section has a row with actual data
                foreach ($data['sections'] ?? [] as $section) {
                    if ($this->hasFilledRows($section['rows'] ?? [])) {
                        $filledSections++;
                        break;
                    }
                }
            } else {
                // Other sections are filled only if at least one row has actual non-empty data
                // (tables always pre-render empty rows, so we can't rely on row count alone)
                if ($this->hasFilledRows($data['rows'] ?? [])) {
                    $filledSections++;
                }
            }
        }

        return $totalSections > 0 ? ($filledSections / $totalSections) * 100 : 0;
    }

    private function hasFilledRows(array $rows): bool
    {
        foreach ($rows as $row) {
            if (! is_array($row)) {
                continue;
            }
            foreach ($row as $value) {
                if ($value !== null && $value !== '' && $value !== false) {
                    return true;
                }
            }
        }

        return false;
    }
}
