<?php

namespace App\Http\Requests\API\Order;

use App\Http\Requests\API\BaseRequest;

class OrderConfirmRequest extends BaseRequest
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
            'order_id' => 'required|exists:orders,id',
            'address' => 'required|exists:addresses,id',
            // 'delivery_type' => 'required|numeric',
            // 'delivery_fee' => 'required|numeric|min:1',
            'payment_method' => 'required|in:bkash,nogod,roket,upay,ssl',
        ];
    }
}