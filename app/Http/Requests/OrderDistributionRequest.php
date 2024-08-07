<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderDistributionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'payment_type' => 'required|numeric',
            'distribution_type' => 'required|numeric',
            'prep_time' => 'required|numeric',
            'note' => 'nullable',
            'datas.*.op_id' => 'required|exists:order_products,id',
            'datas.*.pharmacy_id' => 'required|exists:pharmacies,id',
        ];
    }
}
