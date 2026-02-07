<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class PasswordChangeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'current_password' => 'required|current_password',
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }

    public function messages(): array
    {
        return [
            'current_password.required' => 'Current password is required',
            'current_password.current_password' => 'Current password is incorrect',
            'password.required' => 'New password is required',
            'password.confirmed' => 'Password confirmation does not match',
        ];
    }
}
