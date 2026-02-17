<?php

namespace App\Http\Controllers;

use App\Models\InstrumentSubmissionV2;
use App\Models\InstrumentSubmissionV2Detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PublicInstrumentV2Controller extends Controller
{
    /**
     * Display the v2 instrument form
     */
    public function index()
    {
        return view('instrument.form-v2');
    }

    /**
     * Store a new submission
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'school_name' => 'required|string|max:255',
            'npsn' => 'nullable|string|max:50',
            'address' => 'required|string',
            'respondent_name' => 'required|string|max:255',
            'respondent_position' => 'required|string|max:255',
            'answers' => 'required|array',
        ], [
            'school_name.required' => 'Nama sekolah wajib diisi',
            'address.required' => 'Alamat sekolah wajib diisi',
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

            // Create the main submission
            $submission = InstrumentSubmissionV2::create([
                'school_name' => $request->school_name,
                'npsn' => $request->npsn,
                'address' => $request->address,
                'respondent_name' => $request->respondent_name,
                'respondent_position' => $request->respondent_position,
                'form_version' => '2.0',
                'answers' => $request->answers,
                'status' => InstrumentSubmissionV2::STATUS_SUBMITTED,
                'filled_at' => now(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // Store section details for analytics
            $this->storeSectionDetails($submission, $request->answers);

            // Calculate completion percentage
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
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->with('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.')
                ->withInput();
        }
    }

    /**
     * Store section details for granular analytics
     */
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
            'C.3.2'
        ];

        foreach ($sectionCodes as $code) {
            if (isset($answers[$code])) {
                $data = $answers[$code];
                $rowCount = 0;

                // Count rows for table-type sections
                if (is_array($data)) {
                    if (isset($data['rows']) && is_array($data['rows'])) {
                        $rowCount = count($data['rows']);
                    } elseif (is_array($data) && isset($data[0])) {
                        // Direct array of rows
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

    /**
     * Calculate completion percentage based on filled answers
     */
    private function calculateCompletionPercentage(array $answers): float
    {
        $totalSections = 8; // Total number of sections
        $filledSections = 0;

        $sectionCodes = [
            'A.1.1',
            'A.2.1',
            'B.1.1',
            'B.2.1',
            'C.1.1',
            'C.2.1',
            'C.3.1',
            'C.3.2'
        ];

        foreach ($sectionCodes as $code) {
            if (isset($answers[$code]) && !empty($answers[$code])) {
                $filledSections++;
            }
        }

        return ($filledSections / $totalSections) * 100;
    }
}
