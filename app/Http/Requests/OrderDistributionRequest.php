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
            'payment_type'=>'required|numeric',
            'distribution_type'=>'required|numeric',
            'prep_time'=>'required|date',
            'note'=>'required',
            'datas.*.cart_id'=>'required|exists:add_to_carts,id',
            'datas.*.pharmacy_id'=>'required|exists:pharmacies,id',
        ];
    }
}
