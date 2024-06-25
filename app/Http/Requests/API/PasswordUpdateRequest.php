<?php

namespace App\Http\Requests\API;

use App\Http\Requests\API\BaseRequest;
use Illuminate\Support\Facades\Hash;

class PasswordUpdateRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'old_password' => 'required|min:6',
            'new_password' => 'required|min:6|confirmed',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!$this->checkOldPassword()) {
                $validator->errors()->add('old_password', 'Old password does not match our records.');
            }
        });
    }

    protected function checkOldPassword()
    {
        $user = $this->user();
        return Hash::check($this->old_password, $user->password);
    }
}
