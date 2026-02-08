<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    protected function prepareForValidation()
    {
        // If answer_options is a JSON string (from structure/table editor), decode it
        if ($this->has('answer_options') && is_string($this->answer_options) && $this->answer_type === 'structure') {
            $decoded = json_decode($this->answer_options, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $this->merge([
                    'answer_options' => $decoded,
                ]);
            }
        }

        // Split text-based options if coming from implicit choice text area
        if ($this->has('answer_options') && is_string($this->answer_options) && $this->answer_type === 'choice') {
            $options = array_filter(array_map('trim', explode("\n", $this->answer_options)));
            $this->merge([
                'answer_options' => array_values($options)
            ]);
        }
    }

    public function rules(): array
    {
        $questionId = $this->route('question');

        return [
            'question_code' => 'required|string|max:20|unique:assessment_questions,question_code,' . $questionId,
            'indicator_id' => 'required|exists:assessment_indicators,id',
            'question_text' => 'required|string|max:1000',
            'answer_type' => 'required|in:boolean,scale,number,text,multiple_choice,choice,percentage,date,structure',
            'weight' => 'nullable|numeric|min:0|max:100',
            'order' => 'nullable|integer|min:1',
            'help_text' => 'nullable|string|max:500',
            'is_required' => 'nullable|boolean',
            'max_score' => 'required_if:answer_type,scale,number|numeric|min:0',
            'min_score' => 'required_if:answer_type,scale,number|numeric|min:0',
            'scale_template_id' => 'nullable|exists:scale_templates,id',
            'answer_options' => 'nullable|array',
        ];
    }

    public function messages(): array
    {
        return [
            'question_code.required' => 'Question code is required',
            'question_code.unique' => 'Question code already exists',
            'indicator_id.required' => 'Indicator is required',
            'question_text.required' => 'Question text is required',
            'answer_type.required' => 'Answer type is required',
            'answer_type.in' => 'Invalid answer type',
        ];
    }
}
