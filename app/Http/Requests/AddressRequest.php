<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'name'=>'required|min:4',
            'phone'=>'required|numeric|digits:11',
            'city'=>'required',
            'apartment'=>'required',
            'floor'=>'required',
            'street_address'=>'required|max:300',
            'delivery_instruction'=>'required|max:300',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'apartment_type' => 'required|in:home,office',
        ];
    }

}
