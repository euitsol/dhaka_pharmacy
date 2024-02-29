<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OperationSubAreaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'oa_id'=>'required|exists:operation_areas,id',
        ]
        +
            ($this->isMethod('POST') ? $this->store() : $this->update());
    }

    protected function store(): array
    {
        return [
            'slug' => 'required|unique:operation_sub_areas,slug',

        ];
    }

    protected function update(): array
    {
        return [
            'slug' => 'required|unique:operation_sub_areas,slug,' . $this->route('id'),
        ];
    }
}
