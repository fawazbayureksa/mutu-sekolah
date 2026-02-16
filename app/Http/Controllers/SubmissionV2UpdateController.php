<?php

namespace App\Http\Controllers;

use App\Models\InstrumentSubmissionV2;
use App\Models\InstrumentSubmissionV2Detail;
use App\Models\Province;
use App\Models\Regency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SubmissionV2UpdateController extends Controller
{
    public function show($token)
    {
        $submission = InstrumentSubmissionV2::with(['school', 'details'])->where('update_token', $token)
            ->firstOrFail();

        if (! $submission->hasValidUpdateToken()) {
            abort(404, 'Token tidak valid atau sudah kedaluwarsa.');
        }

        $answers = $submission->answers ?? [];

        // Decode JSON string values — the frontend submits each section as a JSON string
        foreach ($answers as $key => $value) {
            if (is_string($value)) {
                $decoded = json_decode($value, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $answers[$key] = $decoded;
                }
            }
        }

        // Always prefer details data (source of truth) over answers column
        if ($submission->details->isNotEmpty()) {
            foreach ($submission->details as $detail) {
                $detailData = $detail->data ?? [];
                if (is_string($detailData)) {
                    $decoded = json_decode($detailData, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                        $detailData = $decoded;
                    }
                }
                $answers[$detail->section_code] = $detailData;
            }
            $submission->answers = $answers;
        }

        $provinces = Province::orderBy('name')->get();
        $regencies = [];

        if ($submission->province_code) {
            $regencies = Regency::where('province_code', $submission->school->province_code)
                ->orderBy('name')
                ->get();
        }

        $expertiseData = config('constant.expertise', []);
        $respondentPositions = config('constant.respondent_positions', []);
        $updateUrl = route('submissions-v2.update.show', $token);

        return view('submissions.update-v2', compact(
            'submission',
            'updateUrl',
            'provinces',
            'regencies',
            'expertiseData',
            'respondentPositions'
        ));
    }

    public function update(Request $request, $token)
    {
        $submission = InstrumentSubmissionV2::where('update_token', $token)
            ->firstOrFail();

        if (! $submission->hasValidUpdateToken()) {
            return back()->with('error', 'Token tidak valid atau sudah kedaluwarsa.');
        }

        $validator = Validator::make($request->all(), [
            'school_name' => 'sometimes|required|string|max:255',
            'npsn' => 'nullable|string|max:50',
            'address' => 'sometimes|required|string',
            'province_code' => 'sometimes|required|string',
            'regency_code' => 'sometimes|required|string',
            'expertise' => 'nullable|string|max:255',
            'expertise_program' => 'nullable|string|max:255',
            'expertise_concentration' => 'nullable|string|max:255',
            'respondent_name' => 'sometimes|required|string|max:255',
            'respondent_position' => 'sometimes|required|string|max:255',
            'answers' => 'sometimes|array',
        ], [
            'school_name.required' => 'Nama sekolah wajib diisi jika Anda ingin memperbarui data sekolah.',
            'address.required' => 'Alamat wajib diisi jika Anda ingin memperbarui data sekolah.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            // Collect data to update
            $data = [];

            if ($request->filled('school_name')) {
                $data['school_name'] = $request->school_name;
            }
            if ($request->filled('npsn')) {
                $data['npsn'] = $request->npsn;
            }
            if ($request->filled('address')) {
                $data['address'] = $request->address;
            }
            if ($request->filled('province_code')) {
                $data['province_code'] = $request->province_code;
            }
            if ($request->filled('regency_code')) {
                $data['regency_code'] = $request->regency_code;
            }
            if ($request->filled('expertise')) {
                $data['expertise'] = $request->expertise;
            }
            if ($request->filled('expertise_program')) {
                $data['expertise_program'] = $request->expertise_program;
            }
            if ($request->filled('expertise_concentration')) {
                $data['expertise_concentration'] = $request->expertise_concentration;
            }
            if ($request->filled('respondent_name')) {
                $data['respondent_name'] = $request->respondent_name;
            }
            if ($request->filled('respondent_position')) {
                $data['respondent_position'] = $request->respondent_position;
            }

            // Update answers if provided
            if ($request->filled('answers') && is_array($request->answers)) {
                $newAnswers = [];
                foreach ($request->answers as $key => $value) {
                    if (!empty($value)) {
                        $newAnswers[$key] = $value;
                    }
                }
                if (!empty($newAnswers)) {
                    $existingAnswers = $submission->answers ?? [];
                    $data['answers'] = array_merge($existingAnswers, $newAnswers);
                }
            }

            // Only update if there is data to update
            if (! empty($data)) {
                $submission->update($data);
            }

            // Update section details if answers were provided
            if (isset($data['answers'])) {
                $this->updateSectionDetails($submission, $data['answers']);
            }

            DB::commit();

            // Mark token as used after successful update
            $submission->update([
                'update_token_used_at' => now(),
            ]);

            return back()->with('success', 'Data sekolah berhasil diperbarui. Link update akan berlaku selama 24 jam.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Terjadi kesalahan saat memperbarui data. Silakan coba lagi.');
        }
    }

    private function updateSectionDetails(InstrumentSubmissionV2 $submission, array $answers): void
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

                InstrumentSubmissionV2Detail::updateOrCreate(
                    [
                        'submission_id' => $submission->id,
                        'section_code' => $code,
                    ],
                    [
                        'data' => $data,
                        'row_count' => $rowCount,
                    ]
                );
            }
        }
    }
}
