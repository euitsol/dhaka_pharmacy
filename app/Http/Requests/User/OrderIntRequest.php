<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;

class OrderIntRequest extends FormRequest
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
        $rules = [];

        if ($this->has('product') || $this->has('unit_id') || $this->has('quantity')) {
            $rules = [
                'product' => 'required|exists:medicines,id',
                'unit_id' => 'required|exists:medicine_units,id',
                'quantity' => 'required|numeric|min:1',
            ];
        }

        return $rules;
    }
}