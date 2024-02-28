<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DistrictManagerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|min:4',
            
            'age'=>'nullable|numeric|digits:2',
            'area'=>'nullable',
            'identification_type' => 'nullable|in:NID,DOB,Passport',
            'identification_no'=>'nullable|numeric',
            'present_address'=>'nullbale',
            'cv'=>'nullable|file|mimes:pdf',


            'gender'=>'nullable|in:Male,Female,Others',
            'dob'=>'nullable|date|before:today',
            'father_name'=>'nullable|min:6',
            'mother_name'=>'nullable|min:6',
            'permanent_address'=>'nullable',
            'parent_phone'=>'nullable|numeric|digits:11',

            'oa_id'=>'required|exists:operation_areas,id',

        ]
        +
        ($this->isMethod('POST') ? $this->store() : $this->update());
    }

    protected function store(): array
    {
        return [
            'email' => 'nullable|unique:district_managers,email',
            'phone' => 'required|numeric|digits:11|unique:district_managers,phone',
            'password' => 'required|min:6|confirmed'
        ];
    }

    protected function update(): array
    {
        return [
            'email' => 'nullable|unique:district_managers,email,' . $this->route('id'),
            'phone' => 'required|numeric|digits:11|unique:district_managers,phone,' . $this->route('id'),
            'password' => 'nullable|min:6|confirmed',
        ];
    }
}
