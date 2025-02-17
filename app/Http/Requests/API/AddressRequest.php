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
        $rules = [
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'address' => 'required|string|max:255',
            'city' => 'required|exists:delivery_zone_cities,city_name',
            'street_address' => 'nullable|string|max:255',
            'apartment' => 'nullable|string|max:255',
            'floor' => 'nullable|string|max:255',
            'delivery_instruction' => 'nullable|string|max:1000',
            'note' => 'nullable|string|max:1000',
            'is_default' => 'nullable|boolean',
        ];

        if (request()->has('address_id')) {
            $rules['address_id'] = 'required|exists:addresses,id';
        }

        return $rules;
    }
}
