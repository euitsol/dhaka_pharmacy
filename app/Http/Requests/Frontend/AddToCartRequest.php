<?php

namespace App\Http\Requests\Frontend;

use App\Rules\CartProductRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;

class AddToCartRequest extends FormRequest
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
            'slug' => ['required', 'string', 'exists:medicines,slug', new CartProductRule(auth()->user())],
            'unit' => 'nullable|exists:medicine_units,id',
            'quantity' => 'nullable|numeric'
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        $errors = $validator->errors();
        $response = new JsonResponse([
            'success' => false,
            'message' => 'Validation errors occurred.',
            'errors' => $errors->messages()
        ], status: 422);
        throw new HttpResponseException($response);
    }
}
