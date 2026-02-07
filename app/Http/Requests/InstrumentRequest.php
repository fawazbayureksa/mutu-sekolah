<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstrumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
        // return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        $instrumentId = $this->route('instrument') ? $this->route('instrument')->id : null;

        return [
            'code' => 'required|string|max:50|unique:instruments,code,' . $instrumentId,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'version' => 'nullable|string|max:20',
            'instructions' => 'nullable|string',
            'estimated_duration' => 'nullable|integer|min:1',
            'scoring_method' => 'nullable|in:simple_sum,weighted_sum,average,percentage,custom',
            'is_active' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'Code is required',
            'code.unique' => 'Code already exists',
            'name.required' => 'Name is required',
            'scoring_method.in' => 'Invalid scoring method',
        ];
    }
}
