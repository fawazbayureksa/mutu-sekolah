<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssessmentAnswerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'question_id' => 'required|exists:assessment_questions,id',
            'answer' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'question_id.required' => 'Question is required',
            'question_id.exists' => 'Question not found',
            'answer.required' => 'Answer is required',
        ];
    }
}
