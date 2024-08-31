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
            'phone' => 'required|numeric|digits:11|unique:pharmacies,phone,' . pharmacy()->id,
            'email' => 'required|email|unique:pharmacies,email,' . pharmacy()->id,
            'identification_type' => 'nullable|numeric',
            'identification_file' => 'nullable|file|mimes:pdf',
            'emergency_phone' => 'nullable|numeric|digits:11',
            'oa_id' => 'nullable|exists:operation_areas,id',
            'osa_id' => 'nullable|exists:operation_sub_areas,id',
        ];
    }
}
