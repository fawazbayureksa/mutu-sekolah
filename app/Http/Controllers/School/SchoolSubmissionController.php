<?php

namespace App\Http\Controllers\School;

use App\Exports\SubmissionV2Export;
use App\Http\Controllers\Controller;
use App\Models\InstrumentSubmissionV2;
use App\Models\InstrumentSubmissionV2Detail;
use App\Models\Province;
use App\Models\Regency;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class SchoolSubmissionController extends Controller
{
    private function getSchool()
    {
        $user   = Auth::user();
        $school = $user->school;

        if (! $school) {
            // Auto-create a placeholder so first-time users can proceed
            $existing = School::where('npsn', $user->npsn)->whereNull('user_id')->first();

            if ($existing) {
                $existing->update(['user_id' => $user->id]);
                $school = $existing->fresh();
            } else {
                $school = School::create([
                    'user_id'     => $user->id,
                    'school_name' => 'Sekolah ' . $user->npsn,
                    'npsn'        => $user->npsn,
                    'address'     => '',
                ]);
            }
        }

        return $school;
    }

    private function authorizeSubmission(InstrumentSubmissionV2 $submission): void
    {
        if ($submission->school_id !== $this->getSchool()->id) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }
    }

    public function exportSingle(InstrumentSubmissionV2 $submission)
    {
        $this->authorizeSubmission($submission);

        $submission->load(['school', 'province', 'regency', 'verifier', 'validator']);

        $npsn     = $submission->npsn ?? $submission->school?->npsn ?? 'unknown';
        $date     = now()->format('Ymd');
        $fileName = "pengajuan-{$npsn}-{$date}.xlsx";

        return Excel::download(new SubmissionV2Export($submission), $fileName);
    }

    public function index()
    {
        $school = $this->getSchool();

        $submissions = InstrumentSubmissionV2::where('school_id', $school->id)
            ->latest('filled_at')
            ->paginate(15);

        return view('school.submissions.index', compact('school', 'submissions'));
    }

    public function show(InstrumentSubmissionV2 $submission)
    {
        $school = $this->getSchool();

        if ($submission->school_id !== $school->id) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        $submission->load(['school', 'province', 'regency', 'details']);

        // Merge details into answers (details are the source of truth)
        $answers = $submission->answers ?? [];
        foreach ($answers as $key => $value) {
            if (is_string($value)) {
                $decoded = json_decode($value, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $answers[$key] = $decoded;
                }
            }
        }
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

        return view('school.submissions.show', compact('school', 'submission'));
    }

    public function editFull(InstrumentSubmissionV2 $submission)
    {
        $school = $this->getSchool();

        if ($submission->school_id !== $school->id) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        // if (!$submission->isEditable()) {
        //     return redirect()->route('school.submissions.show', $submission)
        //         ->with('error', 'Pengajuan ini tidak dapat diedit pada status saat ini.');
        // }

        $submission->load(['school', 'details']);

        // Decode answers + prefer details
        $answers = $submission->answers ?? [];
        foreach ($answers as $key => $value) {
            if (is_string($value)) {
                $decoded = json_decode($value, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $answers[$key] = $decoded;
                }
            }
        }
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
        $regencies = $submission->province_code
            ? Regency::where('province_code', $submission->province_code)->orderBy('name')->get()
            : collect();

        $expertiseData        = config('constant.expertise', []);
        $expertiseByCurriculum = config('constant.expertise_by_curriculum', []);
        $respondentPositions  = config('constant.respondent_positions', []);
        $updateUrl            = route('school.submissions.update-full', $submission);

        return view('submissions.update-v2', compact(
            'submission',
            'updateUrl',
            'provinces',
            'regencies',
            'expertiseData',
            'expertiseByCurriculum',
            'respondentPositions'
        ));
    }

    public function updateFull(Request $request, InstrumentSubmissionV2 $submission)
    {
        $school = $this->getSchool();

        if ($submission->school_id !== $school->id) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        // if (! $submission->isEditable()) {
        //     return redirect()->route('school.submissions.show', $submission)
        //         ->with('error', 'Pengajuan ini tidak dapat diedit pada status saat ini.');
        // }

        $validator = Validator::make($request->all(), [
            'school_name'             => 'sometimes|required|string|max:255',
            'npsn'                    => 'nullable|string|max:50',
            'address'                 => 'sometimes|required|string',
            'province_code'           => 'sometimes|required|string',
            'regency_code'            => 'sometimes|required|string',
            'school_status'           => 'nullable|string|max:20',
            'school_category'         => 'nullable|string|max:100',
            'program_duration'        => 'nullable|string|max:50',
            'school_accreditation'    => 'nullable|string|max:50',
            'curriculum'              => 'nullable|string|max:50',
            'expertise'               => 'nullable|string|max:255',
            'expertise_program'       => 'nullable|string|max:255',
            'expertise_concentration' => 'nullable|string|max:255',
            'respondent_name'         => 'sometimes|required|string|max:255',
            'respondent_position'     => 'sometimes|required|string|max:255',
            'answers'                 => 'sometimes|array',
        ]);

        if ($validator->fails()) {
            return redirect()->route('school.submissions.edit-full', $submission)
                ->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $fields = [
                'school_name',
                'npsn',
                'address',
                'province_code',
                'regency_code',
                'school_status',
                'school_category',
                'program_duration',
                'school_accreditation',
                'curriculum',
                'expertise',
                'expertise_program',
                'expertise_concentration',
                'respondent_name',
                'respondent_position',
            ];

            $data = [];
            foreach ($fields as $field) {
                if ($request->filled($field)) {
                    $data[$field] = $request->input($field);
                }
            }

            if ($request->filled('answers') && is_array($request->answers)) {
                $newAnswers = array_filter($request->answers, fn($v) => ! empty($v));
                if (! empty($newAnswers)) {
                    $data['answers'] = array_merge($submission->answers ?? [], $newAnswers);
                }
            }

            if (! empty($data)) {
                // If the submission was rejected and school submits an update, revert to submitted
                if ($submission->status === InstrumentSubmissionV2::STATUS_REJECTED) {
                    $data['status'] = InstrumentSubmissionV2::STATUS_SUBMITTED;
                }

                $submission->update($data);

                // Sync relevant fields back to the school record
                $schoolFields = array_intersect_key($data, array_flip([
                    'school_name',
                    'address',
                    'province_code',
                    'regency_code',
                    'school_status',
                    'school_category',
                    'program_duration',
                    'school_accreditation',
                    'curriculum',
                    'expertise',
                    'expertise_program',
                    'expertise_concentration',
                ]));
                if (! empty($schoolFields)) {
                    $school->update($schoolFields);
                }
            }

            if (isset($data['answers'])) {
                $this->updateSectionDetails($submission, $data['answers']);
                $submission->update([
                    'completion_percentage' => $this->calculateCompletionPercentage($data['answers']),
                ]);
            }

            DB::commit();

            return redirect()->route('school.submissions.show', $submission)
                ->with('success', 'Data pengajuan berhasil diperbarui dan diajukan kembali untuk verifikasi.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('school.submissions.edit-full', $submission)
                ->with('error', 'Terjadi kesalahan saat memperbarui data. Silakan coba lagi.');
        }
    }

    public function resubmit(InstrumentSubmissionV2 $submission)
    {
        $school = $this->getSchool();

        if ($submission->school_id !== $school->id) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        if ($submission->status !== InstrumentSubmissionV2::STATUS_REJECTED) {
            return redirect()->route('school.submissions.show', $submission)
                ->with('error', 'Hanya pengajuan yang ditolak yang dapat diajukan kembali.');
        }

        $submission->update(['status' => InstrumentSubmissionV2::STATUS_SUBMITTED]);

        return redirect()->route('school.submissions.show', $submission)
            ->with('success', 'Pengajuan berhasil diajukan kembali dan menunggu verifikasi.');
    }

    private function updateSectionDetails(InstrumentSubmissionV2 $submission, array $answers): void
    {
        $sectionCodes = config('constant.section_codes');

        foreach ($sectionCodes as $code) {
            if (isset($answers[$code])) {
                $data     = $answers[$code];
                $rowCount = 0;
                if (is_array($data)) {
                    if ($code === 'B.sapras') {
                        foreach ($data['sections'] ?? [] as $section) {
                            $rowCount += count($section['rows'] ?? []);
                        }
                    } elseif (isset($data['rows']) && is_array($data['rows'])) {
                        $rowCount = count($data['rows']);
                    } elseif (isset($data[0])) {
                        $rowCount = count($data);
                    }
                }
                InstrumentSubmissionV2Detail::updateOrCreate(
                    ['submission_id' => $submission->id, 'section_code' => $code],
                    ['data' => $data, 'row_count' => $rowCount]
                );
            }
        }
    }

    public function edit(InstrumentSubmissionV2 $submission)
    {
        $school = $this->getSchool();

        if ($submission->school_id !== $school->id) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        // if (! $submission->isEditable()) {
        //     return redirect()->route('school.submissions.show', $submission)
        //         ->with('error', 'Pengajuan ini tidak dapat diedit pada status saat ini.');
        // }

        return view('school.submissions.edit', compact('school', 'submission'));
    }

    public function update(Request $request, InstrumentSubmissionV2 $submission)
    {
        $school = $this->getSchool();

        if ($submission->school_id !== $school->id) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        // if (! $submission->isEditable()) {
        //     return redirect()->route('school.submissions.show', $submission)
        //         ->with('error', 'Pengajuan ini tidak dapat diedit pada status saat ini.');
        // }

        $request->validate([
            'respondent_name'     => ['required', 'string', 'max:255'],
            'respondent_position' => ['required', 'string', 'max:255'],
        ]);

        $submission->update([
            'respondent_name'     => $request->input('respondent_name'),
            'respondent_position' => $request->input('respondent_position'),
            'status'              => 'submitted',
        ]);

        return redirect()->route('school.submissions.show', $submission)
            ->with('success', 'Pengajuan berhasil diperbarui.');
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
