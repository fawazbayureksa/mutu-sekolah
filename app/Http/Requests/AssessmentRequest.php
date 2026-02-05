<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssessmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'school_id' => 'required|exists:schools,id',
            'instrument_id' => 'required|exists:instruments,id',
            'period_year' => 'required|string|max:20',
            'semester' => 'nullable|in:1,2',
            'assessment_type' => 'nullable|string|max:50',
            'remarks' => 'nullable|string|max:1000',
            'metadata' => 'nullable|array',
        ];
    }

    public function messages(): array
    {
        return [
            'school_id.required' => 'School is required',
            'school_id.exists' => 'School not found',
            'instrument_id.required' => 'Instrument is required',
            'instrument_id.exists' => 'Instrument not found',
            'period_year.required' => 'Period year is required',
        ];
    }
}
