<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LocalAreaManagerRequest extends FormRequest
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

            'osa_id'=>'nullable|exists:operation_sub_areas,id',
            'dm_id'=>'required|exists:district_managers,id',
        ]
        +
        ($this->isMethod('POST') ? $this->store() : $this->update());
    }

    protected function store(): array
    {
        return [
            'email' => 'nullable|unique:local_area_managers,email',
            'phone' => 'required|numeric|digits:11|unique:local_area_managers,phone',
            'password' => 'required|min:6|confirmed',
        ];
    }

    protected function update(): array
    {
        return [
            'email' => 'nullable|unique:local_area_managers,email,' . $this->route('id'),
            'phone' => 'required|numeric|digits:11|unique:local_area_managers,phone,' . $this->route('id'),
            'password' => 'nullable|min:6|confirmed',
        ];
    }
    
}
