<?php

namespace App\Http\Requests\API\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\API\BaseRequest;
use App\Rules\CartBelongsToUserRule;

class CartDeleteRequest extends BaseRequest
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
            'carts' => 'required|array',
            'carts.*' => ['required','integer','exists:add_to_carts,id',new CartBelongsToUserRule($this->user())],
        ];
    }
}
