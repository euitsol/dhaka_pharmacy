<?php

namespace App\Rules\ApiRules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\User;

class PasswordNotSet implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $user = User::where('phone', $value)->first();

        if ($user && is_null($user->password)) {
            $fail('Your password is not set yet. Please login with OTP and set your password in your profile.');
        }
    }
}
