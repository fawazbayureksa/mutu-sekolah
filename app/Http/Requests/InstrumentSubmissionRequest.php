<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\InstrumentItem;

class InstrumentSubmissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // School data
            'school_name' => ['required', 'string', 'max:255'],
            'npsn' => ['nullable', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:500'],

            // Respondent data
            'respondent_name' => ['required', 'string', 'max:255'],
            'respondent_position' => ['required', 'string', 'max:255'],

            // Answers array
            'answers' => ['required', 'array', 'min:1'],
            'answers.*' => ['present'], // Allow empty for optional questions
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $this->validateAnswerTypes($validator);
        });
    }

    /**
     * Validate answer types against question definitions
     *
     * @param \Illuminate\Validation\Validator $validator
     * @return void
     */
    protected function validateAnswerTypes($validator): void
    {
        $answers = $this->input('answers', []);

        foreach ($answers as $itemId => $answer) {
            $item = InstrumentItem::with('question')->find($itemId);

            if (!$item) {
                $validator->errors()->add(
                    "answers.{$itemId}",
                    "Item tidak ditemukan."
                );
                continue;
            }

            $question = $item->question;
            $answerType = $question?->answer_type ?? $item->answer_type;
            $isRequired = $question?->is_required ?? true;

            // Skip empty answers for optional questions
            if (empty($answer) && !$isRequired) {
                continue;
            }

            // Validate required
            if (empty($answer) && $isRequired) {
                $validator->errors()->add(
                    "answers.{$itemId}",
                    "Pertanyaan ini wajib diisi."
                );
                continue;
            }

            // Type-specific validation
            match ($answerType) {
                'boolean' => $this->validateBoolean($validator, $itemId, $answer),
                'scale', 'multiple_choice' => $this->validateScale($validator, $itemId, $answer, $question),
                'number' => $this->validateNumber($validator, $itemId, $answer),
                'percentage' => $this->validatePercentage($validator, $itemId, $answer),
                'structure' => $this->validateStructure($validator, $itemId, $answer, $question),
                default => null,
            };
        }
    }

    /**
     * Validate boolean answer
     */
    protected function validateBoolean($validator, $itemId, $answer): void
    {
        if (!in_array($answer, ['Yes', 'No', 'yes', 'no', '1', '0'])) {
            $validator->errors()->add(
                "answers.{$itemId}",
                "Jawaban harus Ya atau Tidak."
            );
        }
    }

    /**
     * Validate scale/multiple choice answer
     */
    protected function validateScale($validator, $itemId, $answer, $question): void
    {
        $options = $question?->getAnswerOptionsArray() ?? [];

        // Skip validation if no options configured (fallback to accept any non-empty)
        if (empty($options)) {
            return;
        }

        $validValues = array_column($options, 'value');

        // Also check for 'key' or 'label' as value alternatives
        if (empty($validValues)) {
            $validValues = array_column($options, 'key');
        }
        if (empty($validValues)) {
            $validValues = array_column($options, 'label');
        }

        // Skip validation if still no valid values found
        if (empty($validValues)) {
            return;
        }

        // Use loose comparison (string '1' == int 1)
        if (!in_array($answer, $validValues)) {
            $validator->errors()->add(
                "answers.{$itemId}",
                "Pilihan tidak valid. Nilai yang diterima: " . implode(', ', $validValues)
            );
        }
    }

    /**
     * Validate number answer
     */
    protected function validateNumber($validator, $itemId, $answer): void
    {
        if (!is_numeric($answer)) {
            $validator->errors()->add(
                "answers.{$itemId}",
                "Jawaban harus berupa angka."
            );
        }
    }

    /**
     * Validate percentage answer
     */
    protected function validatePercentage($validator, $itemId, $answer): void
    {
        if (!is_numeric($answer) || $answer < 0 || $answer > 100) {
            $validator->errors()->add(
                "answers.{$itemId}",
                "Persentase harus antara 0-100."
            );
        }
    }

    /**
     * Validate structure/table answer
     */
    protected function validateStructure($validator, $itemId, $answer, $question): void
    {
        $parsed = is_string($answer) ? json_decode($answer, true) : $answer;

        if (json_last_error() !== JSON_ERROR_NONE) {
            $validator->errors()->add(
                "answers.{$itemId}",
                "Format data tabel tidak valid."
            );
            return;
        }

        if (!is_array($parsed)) {
            $validator->errors()->add(
                "answers.{$itemId}",
                "Data tabel harus berupa array."
            );
            return;
        }

        // Validate against schema
        $schema = $question?->answer_options ?? [];
        $requiredColumns = collect($schema['columns'] ?? [])
            ->where('required', true)
            ->pluck('key')
            ->toArray();

        foreach ($parsed as $rowIndex => $row) {
            if (!is_array($row)) {
                continue;
            }

            foreach ($requiredColumns as $col) {
                if (!isset($row[$col]) || $row[$col] === '') {
                    $validator->errors()->add(
                        "answers.{$itemId}",
                        "Kolom {$col} pada baris " . ($rowIndex + 1) . " wajib diisi."
                    );
                }
            }
        }
    }

    /**
     * Get custom messages for validation errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'school_name.required' => 'Nama sekolah wajib diisi.',
            'npsn.regex' => 'NPSN harus terdiri dari 8 digit angka.',
            'address.required' => 'Alamat sekolah wajib diisi.',
            'respondent_name.required' => 'Nama responden wajib diisi.',
            'respondent_position.required' => 'Jabatan responden wajib diisi.',
            'answers.required' => 'Setidaknya satu jawaban harus diisi.',
        ];
    }
}
