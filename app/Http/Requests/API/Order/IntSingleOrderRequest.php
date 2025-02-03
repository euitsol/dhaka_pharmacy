<?php

namespace App\Http\Requests\API\Order;

use App\Http\Requests\API\BaseRequest;
use App\Rules\UnitAssignedToMedicine;

class IntSingleOrderRequest extends BaseRequest
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
            'product_slug' => 'required|exists:medicines,slug',
            'unit_id' => ['required', 'exists:medicine_units,id', new UnitAssignedToMedicine($this->input('product_slug'))],
            'quantity' => 'required|numeric|min:1',
        ];
    }
}
