<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductSubCategoryRequest extends FormRequest
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
            'name' => 'required',
            'pro_cat_id'=>'required|exists:product_categories,id',
        ]
        +
            ($this->isMethod('POST') ? $this->store() : $this->update());
    }

    protected function store(): array
    {
        return [
            
            'slug' => 'required|unique:medicine_sub_categories,slug',

        ];
    }

    protected function update(): array
    {
        return [
            'slug' => 'required|unique:medicine_sub_categories,slug,' . $this->route('id'),
        ];
    }
}
