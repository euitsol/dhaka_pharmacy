<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class PasswordUpdateRequest extends FormRequest
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
            'old_password' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!$this->checkOldPassword($value)) {
                        $fail("The $attribute doesn't match the current password.");
                    }
                },
            ],
            'password' => [
                'required',
                Password::min(8) // Minimum length of 8 characters
                    ->mixedCase() // Requires at least one uppercase and one lowercase letter
                    ->letters() // Requires at least one letter
                    ->numbers() // Requires at least one digit
                    ->symbols() // Requires at least one special character
                    ->uncompromised(), // Ensures the password has not been compromised in data leaks
                'confirmed',
            ],
        ];
    }

    /**
     * Check if the given password matches the current user's password.
     *
     * @param string $password
     * @return bool
     */
    private function checkOldPassword(string $password): bool
    {
        return \Hash::check($password, user()->password);
    }
}
