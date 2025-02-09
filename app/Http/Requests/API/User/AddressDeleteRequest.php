<?php

namespace App\Http\Requests\API\User;

use App\Http\Requests\API\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\AddressBelongsToUser as AddressBelongsToUserRule;

class AddressDeleteRequest extends BaseRequest
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
            'id' => ['required','integer','exists:addresses,id',new AddressBelongsToUserRule($this->user())],
        ];
    }
}
