<?php

namespace App\Http\Requests\API;

use App\Http\Requests\API\BaseRequest;

class AddressRequest extends BaseRequest
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

            'latitude' => 'required|string',
            'longitude' => 'required|string',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'street_address' => 'required|string|max:255',
            'apartment' => 'required|string|max:255',
            'floor' => 'required|string|max:255',
            'delivery_instruction' => 'nullable|string|max:1000',
            'note' => 'nullable|string|max:1000',
        ];
    }
}
