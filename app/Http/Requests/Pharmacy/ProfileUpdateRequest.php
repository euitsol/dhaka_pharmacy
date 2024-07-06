<?php

namespace App\Http\Requests\Pharmacy;

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
            'phone' => 'nullable|numeric|digits:11|unique:pharmacies,phone,' . pharmacy()->id,
            'email' => 'required|email|unique:pharmacies,email,' . pharmacy()->id,
            'age' => 'nullable|numeric|digits:2',
            'identification_type' => 'nullable|in:NID,DOB,Passport',
            'identification_no' => 'nullable|numeric',
            'present_address' => 'nullable',
            'cv' => 'nullable|file|mimes:pdf',

            'gender' => 'nullable|in:Male,Female,Others',
            'dob' => 'nullable|date|before:today',
            'father_name' => 'nullable|min:6',
            'mother_name' => 'nullable|min:6',
            'permanent_address' => 'nullable',
            'emergency_phone' => 'nullable|numeric|digits:11',
            'oa_id' => 'nullable|exists:operation_areas,id',
            'osa_id' => 'nullable|exists:operation_sub_areas,id',
        ];
    }
}