<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'address_id' => 'required|exists:addresses,id',
            'ref_user' => 'required|exists:users,id',
            'customer_id' => 'required',
            'customer_type' => 'required',
            'products.*.product_id' => 'required',
            'products.*.unit_id' => 'required',
            'products.*.quantity' => 'required',
            'total_amount' => 'required',
            'payment_getway' => 'required|in:bkash, nogod, roket, upay, ssl',

        ]
        +
        ($this->isMethod('POST') ? $this->store() : $this->update());
    }

    protected function store(): array
    {
        return [
            'email' => 'required|unique:admins,email',
            'password' => 'required|min:6|confirmed',
        ];
    }

    protected function update(): array
    {
        return [
            'email' => 'required|unique:admins,email,' . $this->route('id'),
            'password' => 'nullable|min:6|confirmed',
        ];
    }
}
