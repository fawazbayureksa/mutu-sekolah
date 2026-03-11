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

        return view('instrument.form-v2', compact('provinces', 'respondentPositions', 'expertiseData', 'expertiseByCurriculum'));
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

        // Normalize: try exact match first, then underscore-replaced key
        if (!isset($saprasData[$concentration])) {
            $underscoredKey = str_replace(' ', '_', $concentration);
            if (isset($saprasData[$underscoredKey])) {
                $concentration = $underscoredKey;
            } else {
                return response()->json(['sections' => []], 200);
            }
        }

        return response()->json($saprasData[$concentration]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // Basic fields
            'school_name'           => 'required|string|max:255',
            'npsn'                  => 'nullable|digits:8',
            'address'               => 'required|string|max:1000',

            // Validated against actual DB values
            'province_code'         => ['required', 'string', 'exists:provinces,code'],
            'regency_code'          => ['required', 'string', 'exists:regencies,code'],

            // Enum whitelist validation — only accept known values
            'school_status'         => ['nullable', Rule::in(['Negeri', 'Swasta'])],
            'school_category'       => ['nullable', Rule::in(array_keys(config('constant.school_category')))],
            'program_duration'      => ['nullable', Rule::in(['3 Tahun', '4 Tahun'])],
            'school_accreditation'  => ['nullable', Rule::in(config('constant.school_accreditation'))],
            'curriculum'            => ['nullable', Rule::in(config('constant.curriculum'))],
            'approval_status'       => ['nullable', Rule::in(config('constant.approval_status'))],
            'expertise'             => 'nullable|string|max:255',
            'expertise_program'     => 'nullable|string|max:255',
            'expertise_concentration' => 'nullable|string|max:255',

            'respondent_name'       => 'required|string|max:255',
            'respondent_position'   => ['required', 'string', Rule::in(config('constant.respondent_positions'))],

            // Limit array depth/size to prevent payload bombs
            'answers'               => 'required|array|max:20',
            'answers.*.rows'        => 'sometimes|array|max:200',
        ], [
            'school_name.required'       => 'Nama sekolah wajib diisi',
            'npsn.digits'                => 'NPSN harus 8 digit angka',
            'address.required'           => 'Alamat sekolah wajib diisi',
            'province_code.required'     => 'Provinsi wajib dipilih',
            'province_code.exists'       => 'Provinsi yang dipilih tidak valid',
            'regency_code.required'      => 'Kabupaten/Kota wajib dipilih',
            'regency_code.exists'        => 'Kabupaten/Kota yang dipilih tidak valid',
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

            // Create school only if it doesn't exist — never overwrite existing school
            // data from a public form to prevent data poisoning attacks.
            $schoolAttributes = array_filter([
                'npsn'        => $request->npsn ?? null,
                'school_name' => $request->school_name,
            ]);

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
                    'school_name'            => $request->school_name,
                    'npsn'                   => $request->npsn ?? null,
                    'address'                => $request->address,
                    'province_code'          => $request->province_code,
                    'regency_code'           => $request->regency_code,
                    'school_status'          => $request->school_status,
                    'school_category'        => $request->school_category,
                    'program_duration'       => $request->program_duration,
                    'school_accreditation'   => $request->school_accreditation,
                    'curriculum'             => $request->curriculum,
                    'approval_status'        => $request->approval_status,
                    'expertise'              => $request->expertise,
                    'expertise_program'      => $request->expertise_program,
                    'expertise_concentration' => $request->expertise_concentration,
                ]);
            }

            $submission = InstrumentSubmissionV2::create([
                'school_id'        => $school->id,
                'school_name'      => $request->school_name,
                'npsn'             => $request->npsn ?? null,
                'address'          => $request->address,
                'province_code'    => $request->province_code,
                'regency_code'     => $request->regency_code,
                'respondent_name'  => $request->respondent_name,
                'respondent_position' => $request->respondent_position,
                'form_version'     => '2.0',
                'answers'          => $request->answers,
                'status'           => InstrumentSubmissionV2::STATUS_SUBMITTED,
                'filled_at'        => now(),
                'ip_address'       => $request->ip(),
                'user_agent'       => $request->userAgent(),
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
        $sectionCodes = [
            'A.1.1',
            'A.1.2',
            'A.2.1',
            'A.3',
            'A.4',
            'B.sapras',
            'C.1.1',
            'C.2.1',
            'C.3.1',
            'C.3.2',
            'C.3.3',
        ];

        foreach ($sectionCodes as $code) {
            if (isset($answers[$code])) {
                $data = $answers[$code];
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
        $sectionCodes = [
            'A.1.1',
            'A.1.2',
            'A.2.1',
            'A.3',
            'A.4',
            'B.sapras',
            'C.1.1',
            'C.2.1',
            'C.3.1',
            'C.3.2',
            'C.3.3',
        ];

        $totalSections = count($sectionCodes);
        $filledSections = 0;

        foreach ($sectionCodes as $code) {
            if (! isset($answers[$code]) || empty($answers[$code])) {
                continue;
            }

            // B.sapras is filled only if it has at least one row in any section
            if ($code === 'B.sapras') {
                $hasSaprasRows = false;
                foreach ($answers[$code]['sections'] ?? [] as $section) {
                    if (! empty($section['rows'])) {
                        $hasSaprasRows = true;
                        break;
                    }
                }
                if ($hasSaprasRows) {
                    $filledSections++;
                }
            } else {
                $filledSections++;
            }
        }

        return $totalSections > 0 ? ($filledSections / $totalSections) * 100 : 0;
    }
}
