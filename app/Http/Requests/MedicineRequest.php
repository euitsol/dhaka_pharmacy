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
            'pro_sub_cat_id'=>'required|exists:product_sub_categories,id',
            'generic_id'=>'required|exists:generic_names,id',
            'company_id'=>'required|exists:company_names,id',
            'medicine_cat_id'=>'required|exists:medicine_categories,id',
            'strength_id'=>'required|exists:medicine_strengths,id',
            'unit'=>'required',
            'description'=>'required|min:50',
            'prescription_required'=>'boolean|nullable',
            'kyc_required'=>'boolean|nullable',
            'max_quantity'=>'nullable|numeric',
        ]
        +
            ($this->isMethod('POST') ? $this->store() : $this->update());
        }
    
        protected function store(): array
        {
            return [
                'name' => 'required|unique:medicines,name',

            ];
        }
    
        protected function update(): array
        {
            return [
                'name' => 'required|unique:medicines,name,' . $this->route('id'),
            ];
        }
}