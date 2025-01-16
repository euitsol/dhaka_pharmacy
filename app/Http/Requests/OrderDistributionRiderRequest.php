<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderDistributionRiderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'rider_id'=>'required|exists:riders,id',
            'priority'=>'required|numeric',
            'instraction'=>'nullable'
            
        ];
    }
}
