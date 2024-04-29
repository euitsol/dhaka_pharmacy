<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PharmacyOrderRequest extends FormRequest
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
            'data.*.dop_id'=>'required|exists:order_distribution_pharmacies,id',
            'data.*.status'=>'nullable',
            'data.*.open_amount'=>'nullable|numeric',
            'data.*.note'=>'nullable',
        ];
    }
}
