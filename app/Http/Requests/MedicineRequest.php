<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MedicineRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'price'=>'required|numeric',
            'pro_cat_id'=>'required|exists:product_categories,id',
            'pro_sub_cat_id'=>'nullable|exists:product_sub_categories,id',
            'generic_id'=>'required|exists:generic_names,id',
            'company_id'=>'required|exists:company_names,id',
            'strength_id'=>'nullable',

            'unit'=>'nullable|min:1',
            'unit.*'=>'nullable|exists:medicine_units,id',

            'units.*.id'=>'nullable|exists:medicine_units,id',
            'units.*.price'=>'nullable|numeric',

            'description'=>'nullable',
            'prescription_required'=>'boolean|nullable',
            'kyc_required'=>'boolean|nullable',
            'max_quantity'=>'nullable|numeric',

            'discount_amount'=>'nullable|numeric',
            'discount_percentage'=>'nullable|numeric',
        ]
        +
            ($this->isMethod('POST') ? $this->store() : $this->update());
        }

        protected function store(): array
        {
            return [
                'name' => 'required|unique:medicines,name',
                'slug' => 'required|unique:medicines,slug',

            ];
        }

        protected function update(): array
        {
            return [
                'name' => 'required|unique:medicines,name,' . $this->route('id'),
                'slug' => 'required|unique:medicines,slug,' . $this->route('id'),
            ];
        }
}
