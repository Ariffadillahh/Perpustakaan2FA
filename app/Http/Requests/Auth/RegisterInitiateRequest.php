<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterInitiateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|numeric|digits_between:10,15',
            'role_id' => 'required|exists:roles,id',
            'is_active' => 'nullable|boolean',
        ];

        if ($this->isMethod('POST')) {
            $rules['password'] = 'required|min:6'; 
        } else {
            $rules['password'] = 'nullable|min:6';
        }

        return $rules;
    }
}
