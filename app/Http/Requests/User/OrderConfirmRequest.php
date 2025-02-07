<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class OrderConfirmRequest extends FormRequest
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
            'order_id' => decrypt($this->input('order_id')),
        ]);
    }

    public function rules(): array
    {
        return [
            'order_id' => 'required|exists:orders,order_id',
            'address' => 'required|exists:addresses,id',
            'delivery_type' => 'required|string|in:standard,express',
            'payment_method' => 'required|string|in:bkash,nogod,roket,upay,ssl,cod',
        ];
    }
}
