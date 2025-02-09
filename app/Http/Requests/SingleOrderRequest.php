<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SingleOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'unit_id' => 'required|exists:medicine_units,id',
            'slug' => 'required|exists:medicines,slug',
            'quantity' => 'required|numeric|min:1',
        ];
    }
}
