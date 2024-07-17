<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MapboxSettingRequest extends FormRequest
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
            'mapbox_token' => 'nullable|string',
            'mapbox_style_id' => 'nullable|string',
            'per_km_delivery_charge' => 'nullable|numeric|min:0',
            'min_delivery_charge' => 'nullable|numeric|min:0',
            'miscellaneous_charge' => 'nullable|numeric|min:0',
            'center_location_lng' => 'nullable',
            'center_location_lat' => 'nullable',
            'pharmacy_radious' => 'nullable|numeric',

        ];
    }
}