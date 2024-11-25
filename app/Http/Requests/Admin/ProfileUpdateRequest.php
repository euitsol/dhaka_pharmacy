<?php

namespace App\Http\Requests\Admin;

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
            'phone' => 'nullable|numeric|digits:11|unique:admins,phone,' . admin()->id,
            'emergency_phone' => 'nullable|numeric|digits:11|unique:admins,emergency_phone,' . admin()->id,
            'designation' => 'nullable|min:4',
            'identification_type' => 'nullable|numeric',
            'identification_no' => 'nullable|numeric',
            'identification_file' => 'nullable|file|mimes:pdf',
            'present_address' => 'nullable',
            'permanent_address' => 'nullable',
            'gender' => 'nullable|numeric',
            'date_of_birth' => 'nullable|date|before:today',
            'father_name' => 'nullable|min:6',
            'mother_name' => 'nullable|min:6',
        ];
    }
}