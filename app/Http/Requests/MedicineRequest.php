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
            'name'=>'required',
            'price'=>'required|numeric',
            'pro_cat_id'=>'required|exists:product_categories,id',
            'generic_id'=>'required|exists:generic_names,id',
            'company_id'=>'required|exists:company_names,id',
            'medicine_cat_id'=>'required|exists:medicine_categories,id',
            'strength_id'=>'required|exists:medicine_strengths,id',
            'unit'=>'required',
            'description'=>'required|min:50',
            'prescription_required'=>'boolean|nullable',
        ]
        +
            ($this->isMethod('POST') ? $this->store() : $this->update());
        }
    
        protected function store(): array
        {
            return [
            ];
        }
    
        protected function update(): array
        {
            return [
            ];
        }
}
