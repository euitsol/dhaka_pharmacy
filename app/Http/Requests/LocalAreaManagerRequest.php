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
            'dm_id' => 'required|exists:district_managers,id',

        ]
        +
        ($this->isMethod('POST') ? $this->store() : $this->update());
    }

    protected function store(): array
    {
        return [
            'email' => 'required|unique:local_area_managers,email',
            'password' => 'required|min:6|confirmed',
        ];
    }

    protected function update(): array
    {
        return [
            'email' => 'required|unique:local_area_managers,email,' . $this->route('id'),
            'password' => 'nullable|min:6|confirmed',
        ];
    }
}
