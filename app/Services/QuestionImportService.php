<?php

namespace App\Services;

use App\Exports\QuestionTemplateExport;
use App\Models\AssessmentIndicator;
use App\Models\AssessmentQuestion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class QuestionImportService
{
    protected $errors = [];

    protected $warnings = [];

    protected $successCount = 0;

    protected $failedCount = 0;

    public function import($file): array
    {
        $this->resetCounters();

        try {
            // Parse the Excel file
            $data = $this->parseExcel($file);

            if (empty($data)) {
                $this->errors[] = 'No data found in the uploaded file.';

                return $this->getResult();
            }

            // Validate all rows first
            $validatedData = $this->validateRows($data);

            // Import questions
            $this->importQuestions($validatedData);

            return $this->getResult();
        } catch (\Exception $e) {
            $this->errors[] = 'Import failed: '.$e->getMessage();

            return $this->getResult();
        }
    }

    protected function parseExcel($file): array
    {
        try {
            $spreadsheet = IOFactory::load($file->getPathname());
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

            if (empty($rows)) {
                return [];
            }

            // Get headers from first row
            $headers = array_map('strtolower', array_map('trim', $rows[0]));

            // Required headers
            $requiredHeaders = ['question_code', 'indicator_code', 'question_text', 'answer_type'];
            $missingHeaders = array_diff($requiredHeaders, $headers);

            if (! empty($missingHeaders)) {
                $this->errors[] = 'Missing required columns: '.implode(', ', $missingHeaders);

                return [];
            }

            // Parse data rows
            $data = [];
            for ($i = 1; $i < count($rows); $i++) {
                $row = $rows[$i];

                // Skip empty rows
                if (empty(array_filter($row))) {
                    continue;
                }

                $rowData = [];
                foreach ($headers as $index => $header) {
                    $rowData[$header] = $row[$index] ?? null;
                }

                $rowData['row_number'] = $i + 1;
                $data[] = $rowData;
            }

            return $data;
        } catch (\Exception $e) {
            throw new \Exception('Failed to parse Excel file: '.$e->getMessage());
        }
    }

    protected function validateRows(array $data): array
    {
        $validatedData = [];

        foreach ($data as $row) {
            $validator = Validator::make($row, [
                'question_code' => 'required|string|max:50',
                'indicator_code' => 'required|string|exists:assessment_indicators,indicator_code',
                'question_text' => 'required|string|max:1000',
                'answer_type' => 'required|in:text,number,scale,choice,date',
                'weight' => 'nullable|integer|min:1|max:10',
                'order' => 'nullable|integer|min:1',
                'is_required' => 'nullable|boolean',
                'min_score' => 'nullable|integer',
                'max_score' => 'nullable|integer',
                'help_text' => 'nullable|string|max:500',
                'answer_options' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                $this->errors[] = "Row {$row['row_number']}: ".implode(', ', $validator->errors()->all());
                $this->failedCount++;

                continue;
            }

            // Check if question code already exists
            if (AssessmentQuestion::where('question_code', $row['question_code'])->exists()) {
                $this->warnings[] = "Row {$row['row_number']}: Question code '{$row['question_code']}' already exists and will be skipped.";
                $this->failedCount++;

                continue;
            }

            // Validate answer_type specific requirements
            if ($row['answer_type'] === 'scale') {
                if (empty($row['min_score']) || empty($row['max_score'])) {
                    $this->errors[] = "Row {$row['row_number']}: Scale questions require min_score and max_score.";
                    $this->failedCount++;

                    continue;
                }
            }

            if ($row['answer_type'] === 'choice') {
                if (empty($row['answer_options'])) {
                    $this->errors[] = "Row {$row['row_number']}: Choice questions require answer_options.";
                    $this->failedCount++;

                    continue;
                }
            }

            $validatedData[] = $row;
        }

        return $validatedData;
    }

    protected function importQuestions(array $data): void
    {
        DB::beginTransaction();

        try {
            foreach ($data as $row) {
                // Get indicator
                $indicator = AssessmentIndicator::where('indicator_code', $row['indicator_code'])->first();

                if (! $indicator) {
                    $this->errors[] = "Row {$row['row_number']}: Indicator '{$row['indicator_code']}' not found.";
                    $this->failedCount++;

                    continue;
                }

                // Parse answer options if it's a choice question
                $answerOptions = null;
                if ($row['answer_type'] === 'choice' && ! empty($row['answer_options'])) {
                    $answerOptions = array_map('trim', explode(',', $row['answer_options']));
                }

                // Parse boolean values
                $isRequired = true;
                if (isset($row['is_required'])) {
                    $isRequired = filter_var($row['is_required'], FILTER_VALIDATE_BOOLEAN);
                }

                // Create question
                AssessmentQuestion::create([
                    'question_code' => $row['question_code'],
                    'indicator_id' => $indicator->id,
                    'question_text' => $row['question_text'],
                    'answer_type' => $row['answer_type'],
                    'weight' => $row['weight'] ?? 1,
                    'order' => $row['order'] ?? 999,
                    'help_text' => $row['help_text'] ?? null,
                    'is_required' => $isRequired,
                    'max_score' => $row['max_score'] ?? null,
                    'min_score' => $row['min_score'] ?? null,
                    'scale_template_id' => null,
                    'answer_options' => $answerOptions,
                    'is_active' => true,
                ]);

                $this->successCount++;
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('Failed to import questions: '.$e->getMessage());
        }
    }

    protected function resetCounters(): void
    {
        $this->errors = [];
        $this->warnings = [];
        $this->successCount = 0;
        $this->failedCount = 0;
    }

    protected function getResult(): array
    {
        return [
            'success' => $this->successCount > 0,
            'success_count' => $this->successCount,
            'failed_count' => $this->failedCount,
            'errors' => $this->errors,
            'warnings' => $this->warnings,
            'message' => $this->generateMessage(),
        ];
    }

    protected function generateMessage(): string
    {
        $messages = [];

        if ($this->successCount > 0) {
            $messages[] = "{$this->successCount} question(s) imported successfully.";
        }

        if ($this->failedCount > 0) {
            $messages[] = "{$this->failedCount} question(s) failed to import.";
        }

        if (empty($messages)) {
            return 'No questions were imported.';
        }

        return implode(' ', $messages);
    }

    public function downloadTemplate(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $fileName = 'template_import_pertanyaan.xlsx';

        return Excel::download(new QuestionTemplateExport, $fileName);
    }
}
