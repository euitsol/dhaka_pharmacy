<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class OrderByPrescriptionRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'prescription_id' => 'required|exists:prescriptions,id',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:medicines,id',
            'products.*.unit_id' => 'required|exists:medicine_units,id',
            'products.*.quantity' => 'required|integer|min:1',
            'address_id' => 'required|exists:addresses,id',
            'delivery_type' => 'required|in:standard,express',
            'payment_method' => 'required|in:cod,bkash,nagad,rocket,ssl,card',
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'user_id' => decrypt($this->input('user_id')),
            'prescription_id' => decrypt($this->input('prescription_id')),
        ]);
    }
}
