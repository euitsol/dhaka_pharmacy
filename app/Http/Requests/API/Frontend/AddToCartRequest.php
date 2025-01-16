<?php

namespace App\Http\Requests\API\Frontend;

use App\Rules\ApiRules\CartProductRule;
use App\Http\Requests\API\BaseRequest;

class AddToCartRequest extends BaseRequest
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
        $user = $this->user();
        return [
            'product_slug' => 'required|string|exists:medicines,slug',
            'unit_id' => 'nullable|exists:medicine_units,id',
            'quantity' => 'nullable|numeric'
        ];
    }
}
