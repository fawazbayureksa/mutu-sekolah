<?php

namespace App\Http\Controllers;

use App\Models\InstrumentSubmissionV2;
use App\Models\InstrumentSubmissionV2Detail;
use App\Models\Province;
use App\Models\Regency;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PublicInstrumentV2Controller extends Controller
{
    public function index()
    {
        $provinces = Province::orderBy('name')->get();
        $respondentPositions = config('constant.respondent_positions');
        $expertiseData = config('constant.expertise');

        return view('instrument.form-v2', compact('provinces', 'respondentPositions', 'expertiseData'));
    }

    public function getRegencies($provinceCode)
    {
        $regencies = Regency::where('province_code', $provinceCode)
            ->orderBy('name')
            ->get(['code', 'name']);

        return response()->json($regencies);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'school_name' => 'required|string|max:255',
            'npsn' => 'nullable|string|max:50',
            'address' => 'required|string',
            'province_code' => 'required|string',
            'regency_code' => 'required|string',
            'expertise' => 'nullable|string|max:255',
            'expertise_program' => 'nullable|string|max:255',
            'expertise_concentration' => 'nullable|string|max:255',
            'respondent_name' => 'required|string|max:255',
            'respondent_position' => 'required|string|max:255',
            'answers' => 'required|array',
        ], [
            'school_name.required' => 'Nama sekolah wajib diisi',
            'address.required' => 'Alamat sekolah wajib diisi',
            'province_code.required' => 'Provinsi wajib dipilih',
            'regency_code.required' => 'Kabupaten/Kota wajib dipilih',
            'respondent_name.required' => 'Nama responden wajib diisi',
            'respondent_position.required' => 'Jabatan responden wajib diisi',
            'answers.required' => 'Data instrumen wajib diisi',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            // Create or update School record
            $school = School::updateOrCreate(
                [
                    'school_name' => $request->school_name,
                    'npsn' => $request->npsn ?? null,
                ],
                [
                    'address' => $request->address,
                    'province_code' => $request->province_code,
                    'regency_code' => $request->regency_code,
                    'expertise' => $request->expertise,
                    'expertise_program' => $request->expertise_program,
                    'expertise_concentration' => $request->expertise_concentration,
                ]
            );

            $submission = InstrumentSubmissionV2::create([
                'school_id' => $school->id,
                'school_name' => $request->school_name,
                'npsn' => $request->npsn ?? null,
                'address' => $request->address,
                'province_code' => $request->province_code,
                'regency_code' => $request->regency_code,
                'respondent_name' => $request->respondent_name,
                'respondent_position' => $request->respondent_position,
                'form_version' => '2.0',
                'answers' => $request->answers,
                'status' => InstrumentSubmissionV2::STATUS_SUBMITTED,
                'filled_at' => now(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            $this->storeSectionDetails($submission, $request->answers);

            $submission->update([
                'completion_percentage' => $this->calculateCompletionPercentage($request->answers),
            ]);

            DB::commit();

            Log::info('V2 Instrument submission created', [
                'submission_id' => $submission->id,
                'school_name' => $submission->school_name,
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
            'A.2.1',
            'B.1.1',
            'B.2.1',
            'C.1.1',
            'C.2.1',
            'C.3.1',
            'C.3.2',
        ];

        foreach ($sectionCodes as $code) {
            if (isset($answers[$code])) {
                $data = $answers[$code];
                $rowCount = 0;

                if (is_array($data)) {
                    if (isset($data['rows']) && is_array($data['rows'])) {
                        $rowCount = count($data['rows']);
                    } elseif (is_array($data) && isset($data[0])) {
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
        $totalSections = 8;
        $filledSections = 0;

        $sectionCodes = [
            'A.1.1',
            'A.2.1',
            'B.1.1',
            'B.2.1',
            'C.1.1',
            'C.2.1',
            'C.3.1',
            'C.3.2',
        ];

        foreach ($sectionCodes as $code) {
            if (isset($answers[$code]) && ! empty($answers[$code])) {
                $filledSections++;
            }
        }

        return ($filledSections / $totalSections) * 100;
    }
}
