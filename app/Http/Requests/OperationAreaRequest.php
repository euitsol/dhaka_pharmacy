<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OperationAreaRequest extends FormRequest
{
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
            'name' => 'required|unique:operation_areas,name',
            'slug' => 'required|unique:operation_areas,slug',

        ];
    }

    protected function update(): array
    {
        return [
            'name' => 'required|unique:operation_areas,name,' . $this->route('id'),
            'slug' => 'required|unique:operation_areas,slug,' . $this->route('id'),
        ];
    }
}
