<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PharmacyRequest extends FormRequest
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

        ]
        +
        ($this->isMethod('POST') ? $this->store() : $this->update());
    }

    protected function store(): array
    {
        return [
            'email' => 'required|unique:pharmacies,email',
            'password' => 'required|min:6|confirmed',
        ];
    }

    protected function update(): array
    {
        return [
            'email' => 'required|unique:pharmacies,email,' . $this->route('id'),
            'password' => 'nullable|min:6|confirmed',
        ];
    }
}
