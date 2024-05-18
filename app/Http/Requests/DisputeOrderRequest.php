<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DisputeOrderRequest extends FormRequest
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
            'note'=>'nullable',
            'datas.*.cart_id'=>'required|exists:add_to_carts,id',
            'datas.*.pharmacy_id'=>'required|exists:pharmacies,id',
            'datas.*.dop_id'=>'required|exists:order_distribution_pharmacies,id',
        ];
    }
}
