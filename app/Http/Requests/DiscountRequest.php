<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DiscountRequest extends FormRequest
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
            'pro_id'=>'required|exists:medicines,id',
            'unit_id'=>'nullable|exists:medicine_units,id',
            'discount_amount'=>'nullable|numeric',
            'discount_percentage'=>'nullable|numeric',
        ];
    }
}
