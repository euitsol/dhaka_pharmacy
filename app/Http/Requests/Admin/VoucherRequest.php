<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Voucher;

class VoucherRequest extends FormRequest
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
            'type' => 'required|in:' . implode(',', [
                Voucher::TYPE_PERCENTAGE,
                Voucher::TYPE_FIXED,
                Voucher::TYPE_FREE_SHIPPING,
            ]),
            'discount_amount' => 'required|numeric',
            'min_order_amount' => 'required|numeric',
            'usage_limit' => 'required|integer',
            'user_usage_limit' => 'required|integer',

        ]
            +
            ($this->isMethod('POST') ? $this->store() : $this->update());
    }

    protected function store(): array
    {
        return [
            'code' => 'required|min:4|max:30|unique:vouchers,code',
            'starts_at' => 'required|date|after_or_equal:today',
            'expires_at' => 'required|date|after_or_equal:starts_at',
        ];
    }

    protected function update(): array
    {
        return [
            'code' => 'required|min:4|max:30|unique:vouchers,code,' . $this->route('id'),
            'starts_at' => 'required|date',
            'expires_at' => 'required|date|after_or_equal:starts_at',
        ];
    }
}