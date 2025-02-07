<?php

namespace App\Http\Requests\Frontend;

use App\Rules\CartBelongsToUserRule;
use App\Rules\CartMedicineUnitRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;

class CartUpdateRequest extends FormRequest
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

    protected function failedValidation(Validator $validator): void
    {
        $errors = $validator->errors();
        $response = new JsonResponse([
            'success' => false,
            'errors' => $errors->messages(),
        ], 422);

        throw new HttpResponseException($response);
    }
}
