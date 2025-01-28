<?php

namespace App\Http\Requests\API\Frontend;

use App\Http\Requests\API\BaseRequest;
use App\Rules\CartBelongsToUserRule;
use App\Rules\CartMedicineUnitRule;

class CartUpdateRequest extends BaseRequest
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
            'cart_id' => ['required','exists:add_to_carts,id',new CartBelongsToUserRule($this->user())],
            'unit_id' => ['nullable','exists:medicine_units,id', new CartMedicineUnitRule($this->input('cart_id'))],
            'quantity' => 'nullable|numeric'
        ];
    }
}
