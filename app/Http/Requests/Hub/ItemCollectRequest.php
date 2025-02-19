<?php

namespace App\Http\Requests\Hub;

use Illuminate\Foundation\Http\FormRequest;

class ItemCollectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'order_id' => decrypt($this->order_id),
        ]);
    }
    public function rules(): array
    {
        return [
            'order_id' => ['required', 'exists:orders,id'],
            'data' => 'required|array|min:1',
            'data.*.p_id' => 'required|exists:medicines,id',
            'data.*.pharmacy_id' => 'required|exists:pharmacies,id',
            'data.*.unit_collecting_price' => ['required', 'numeric', 'min:0.01'],
        ];
    }

    public function messages(): array
    {
        return [
            'data.*.p_id.required' => 'The medicine is required.',
            'data.*.p_id.exists' => 'The selected medicine is invalid.',
            'data.*.pharmacy_id.required' => 'The pharmacy field is required.',
            'data.*.pharmacy_id.exists' => 'The selected pharmacy is invalid.',
            'data.*.unit_collecting_price.required' => 'The unit collecting price field is required.',
            'data.*.unit_collecting_price.numeric' => 'The unit collecting price must be numeric.',
            'data.*.unit_collecting_price.min' => 'The unit collecting price must be at least 0.01.',
        ];
    }
}
