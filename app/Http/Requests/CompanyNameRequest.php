<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyNameRequest extends FormRequest
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
            'name' => 'required|unique:company_names,name',
            'slug' => 'required|unique:company_names,slug',

        ];
    }

    protected function update(): array
    {
        return [
            'name' => 'required|unique:company_names,name,' . $this->route('id'),
            'slug' => 'required|unique:company_names,slug,' . $this->route('id'),
        ];
    }
}
