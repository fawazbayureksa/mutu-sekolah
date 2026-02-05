<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->route('user'),
            'phone' => 'nullable|string|max:20',
            'is_active' => 'nullable|boolean',
            'role' => 'nullable|in:admin,user',
            'bio' => 'nullable|string|max:500',
        ];

        if ($this->isMethod('POST')) {
            $rules['password'] = ['required', 'confirmed', Password::defaults()];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'email.email' => 'Email must be valid',
            'email.unique' => 'Email already exists',
            'password.required' => 'Password is required',
            'password.confirmed' => 'Password confirmation does not match',
            'role.in' => 'Role must be admin or user',
        ];
    }
}
