<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
            'lat' => 'nullable|string',
            'long' => 'nullable|string',
            'address' => 'required|string|max:255',
            'city' => 'required|exists:delivery_zone_cities,city_name',
            'street' => 'required|string|max:255',
            'apartment' => 'nullable|string|max:255',
            'floor' => 'nullable|string|max:255',
            'instruction' => 'nullable|string|max:1000',
            'note' => 'nullable|string|max:1000'
        ];
    }
}