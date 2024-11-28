<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
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
            'name' => 'required|min:4',
            'father_name' => 'nullable|min:6',
            'mother_name' => 'nullable|min:6',
            'age' => 'nullable|numeric|digits:2',
            'identification_type' => 'nullable|numeric',
            'identification_no' => 'nullable|numeric',
            'identification_file' => 'nullable|file|mimes:pdf',
            'present_address' => 'nullable|string',
            'permanent_address' => 'nullable|string',
            'gender' => 'nullable|numeric',
            'dob' => 'nullable|date|before:today',
            'emergency_phone' => 'nullable|numeric|digits:11',
            'occupation' => 'nullable|string',
            'bio' => 'nullable|string',
            'email' => 'nullable|email|unique:users,email,' . user()->id,
        ];
    }
}
