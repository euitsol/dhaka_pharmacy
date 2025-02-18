<?php

namespace App\Http\Requests;

use App\Models\HubStaff;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class HubStaffRequest extends FormRequest
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
            'hub' => 'required|exists:hubs,id',

        ] + ($this->isMethod('POST') ? $this->store() : $this->update());
    }
    protected function store(): array
    {
        return [
            'email' => 'required|unique:hub_staff,email',
            'password' => [
                'required',
                'string',
                'confirmed',
                Password::min(6) // Minimum length of 8 characters
                    ->mixedCase(), // Ensures the password has not been compromised in data leaks
            ],
        ];
    }

    protected function update(): array
    {
        return [
            'email' => 'required|unique:hub_staff,email,' . $this->route('id'),
            'password' => [
                'nullable',
                'string',
                'confirmed',
                Password::min(8) // Minimum length of 8 characters
                    ->mixedCase() // Requires at least one uppercase and one lowercase letter
                    ->letters() // Requires at least one letter
                    ->numbers() // Requires at least one digit
                    ->symbols() // Requires at least one special character
                    ->uncompromised(), // Ensures the password has not been compromised in data leaks
            ],
        ];
    }
}
