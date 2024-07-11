<?php

namespace App\Http\Requests\API\Order;

use App\Http\Requests\API\BaseRequest;

class InitiatedRequest extends BaseRequest
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
            'cart_id.*' => 'required|exists:add_to_carts,id',
            'cart_id.*' => 'required|exists:add_to_carts,id',
        ];
    }
}
