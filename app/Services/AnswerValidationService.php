<?php

namespace App\Services;

use App\Models\Assessment;
use App\Models\AssessmentAnswer;
use App\Models\AssessmentQuestion;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AnswerValidationService
{
    public function validateAnswer(array $data, AssessmentQuestion $question): array
    {
        $rules = $this->getValidationRules($question);
        $messages = $this->getValidationMessages($question);

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }

        return $validator->validated();
    }

    public function getValidationRules(AssessmentQuestion $question): array
    {
        $rules = [];

        if ($question->is_required) {
            $rules['answer_value'] = ['required'];
        } else {
            $rules['answer_value'] = ['nullable'];
        }

        switch ($question->answer_type) {
            case 'boolean':
                $rules['answer_value'][] = 'boolean';
                $rules['boolean_value'] = ['boolean'];
                break;
            
            case 'scale':
            case 'number':
                $rules['answer_value'][] = 'numeric';
                $rules['numeric_value'] = ['numeric'];
                
                if ($question->min_score !== null) {
                    $rules['numeric_value'][] = 'min:' . $question->min_score;
                }
                if ($question->max_score !== null) {
                    $rules['numeric_value'][] = 'max:' . $question->max_score;
                }
                break;
            
            case 'percentage':
                $rules['answer_value'][] = 'numeric';
                $rules['numeric_value'] = ['numeric', 'between:0,100'];
                break;
            
            case 'text':
                $rules['answer_value'][] = 'string';
                $rules['answer_value'][] = 'max:5000';
                break;
            
            case 'multiple_choice':
                $options = $question->getAnswerOptionsArray();
                if (!empty($options)) {
                    $validValues = array_column($options, 'value');
                    $rules['answer_value'][] = 'in:' . implode(',', $validValues);
                }
                break;
            
            case 'file':
                $rules['file_path'] = ['required', 'file', 'max:10240'];
                $rules['file_path'][] = 'mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png';
                break;
        }

        return $rules;
    }

    public function getValidationMessages(AssessmentQuestion $question): array
    {
        $messages = [
            'answer_value.required' => 'This field is required.',
            'answer_value.numeric' => 'Please enter a valid number.',
            'answer_value.string' => 'Please enter valid text.',
            'answer_value.in' => 'Please select a valid option.',
            'file_path.required' => 'Please upload a file.',
            'file_path.file' => 'The file must be a valid file.',
            'file_path.max' => 'The file size must not exceed 10MB.',
            'file_path.mimes' => 'The file must be one of: pdf, doc, docx, xls, xlsx, jpg, jpeg, png.',
        ];

        if ($question->answer_type === 'number' || $question->answer_type === 'scale') {
            if ($question->min_score !== null && $question->max_score !== null) {
                $messages['numeric_value.min'] = "The value must be at least {$question->min_score}.";
                $messages['numeric_value.max'] = "The value must not exceed {$question->max_score}.";
            }
        }

        return $messages;
    }

    public function validateAssessmentCompletion(Assessment $assessment): void
    {
        $instrument = $assessment->instrument;
        
        if (!$instrument) {
            throw ValidationException::withMessages([
                'instrument' => ['Instrument not found.'],
            ]);
        }

        $requiredQuestions = $instrument->items->filter(function ($item) {
            return $item->isRequired();
        });

        foreach ($requiredQuestions as $item) {
            $questionId = $item->assessment_question_id;
            if (!$questionId) {
                continue;
            }

            $hasAnswer = $assessment->answers()->where('question_id', $questionId)->exists();
            
            if (!$hasAnswer) {
                throw ValidationException::withMessages([
                    'completion' => ["Please answer all required questions before submitting."],
                ]);
            }
        }
    }

    public function castAnswerValue(array $data, AssessmentQuestion $question): array
    {
        switch ($question->answer_type) {
            case 'boolean':
                $data['boolean_value'] = filter_var($data['answer_value'], FILTER_VALIDATE_BOOLEAN);
                break;
            
            case 'scale':
            case 'number':
            case 'percentage':
                $data['numeric_value'] = (float) $data['answer_value'];
                break;
            
            default:
                $data['numeric_value'] = null;
                $data['boolean_value'] = null;
        }

        return $data;
    }

    public function calculateAnswerScore(array $data, AssessmentQuestion $question): ?float
    {
        switch ($question->answer_type) {
            case 'boolean':
                return $data['boolean_value'] ?? false ? $question->max_score : $question->min_score;
            
            case 'scale':
            case 'number':
            case 'percentage':
                return $data['numeric_value'] ?? 0;
            
            case 'multiple_choice':
                if ($question->scale_template_id) {
                    $template = $question->scaleTemplate;
                    if ($template) {
                        return $template->getScoreForValue($data['answer_value']);
                    }
                }
                
                $options = $question->getAnswerOptionsArray();
                foreach ($options as $option) {
                    if ($option['value'] === $data['answer_value']) {
                        return (float) ($option['score'] ?? 0);
                    }
                }
                break;
        }

        return $data['score'] ?? null;
    }
}
