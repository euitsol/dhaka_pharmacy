<?php

namespace App\Http\Requests\API\Order;

use App\Http\Requests\API\BaseRequest;
use App\Rules\ApiRules\OrderItemStatusCheck;

class InitiatedRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    protected function prepareForValidation(): void
    {
        $this->merge([
            'carts' => json_decode($this->input('carts')),
        ]);
    }


    public function rules(): array
    {
        return [
            'carts' => 'required|array',
            'carts.*' => ['required', 'exists:add_to_carts,id', new OrderItemStatusCheck()],
        ];
    }
}