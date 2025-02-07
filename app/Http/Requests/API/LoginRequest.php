<?php

namespace App\Http\Requests\API;

use App\Http\Requests\API\BaseRequest;
use App\Rules\ApiRules\PasswordNotSet;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Validator;

class LoginRequest extends BaseRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'phone' => ['required', 'string', 'exists:users,phone', new PasswordNotSet()],
            'password' => 'required|min:4'
        ];
    }
}
