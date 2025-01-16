<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MedicineCategoryRequest extends FormRequest
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

        ]
        +
            ($this->isMethod('POST') ? $this->store() : $this->update());
    }

    protected function store(): array
    {
        return [
            'name' => 'required|unique:medicine_categories,name',
            'slug' => 'required|unique:medicine_categories,slug',

        ];
    }

    protected function update(): array
    {
        return [
            'name' => 'required|unique:medicine_categories,name,' . $this->route('id'),
            'slug' => 'required|unique:medicine_categories,slug,' . $this->route('id'),
        ];
    }

}

