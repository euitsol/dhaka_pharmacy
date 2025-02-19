<?php

namespace App\Http\Requests\HubStaff;

use App\Models\HubStaff;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'phone' => 'nullable|numeric|digits:11|unique:hub_staff,phone,' . staff()->id,
            'emergency_phone' => 'nullable|numeric|digits:11|unique:hub_staff,emergency_phone,' . staff()->id,
            'gender' => ['required', 'integer', Rule::in([HubStaff::GENDER_MALE, HubStaff::GENDER_FEMALE, HubStaff::GENDER_OTHER])],
            'bio' => 'nullable|string',
            'age' => 'nullable|numeric|digits:2',
            'date_of_birth' => 'nullable|date|before:today',
        ];
    }
}
