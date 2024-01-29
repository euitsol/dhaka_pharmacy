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
