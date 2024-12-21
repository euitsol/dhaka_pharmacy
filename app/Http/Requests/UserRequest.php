<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:4|max:50',

            'age' => 'nullable|numeric|digits:2',
            'identification_type' => 'nullable|numeric',
            'identification_no' => 'nullable|numeric',
            'present_address' => 'nullbale',


            'gender' => 'nullable|numeric',
            'dob' => 'nullable|date|before:today',
            'father_name' => 'nullable|min:6',
            'mother_name' => 'nullable|min:6',
            'permanent_address' => 'nullable',


        ]
            +
            ($this->isMethod('POST') ? $this->store() : $this->update());
    }

    protected function store(): array
    {
        return [
            'email' => 'nullable|unique:users,email',
            'phone' => 'required|numeric|digits:11|unique:users,phone',
            // 'password' => 'required|min:6|confirmed',
        ];
    }

    protected function update(): array
    {
        return [
            'email' => 'nullable|unique:users,email,' . $this->route('id'),
            'phone' => 'required|numeric|digits:11|unique:users,phone,' . $this->route('id'),
            // 'password' => 'nullable|min:6|confirmed',
        ];
    }
}
