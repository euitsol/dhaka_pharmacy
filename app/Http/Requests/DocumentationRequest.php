<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'module_key' => 'required',
        ];
    }

    public function storeRules(): array
    {
        return [
            'documentation' => 'required',
        ]+
        ($this->rules());
    }

    public function updateRules(): array
    {
        return [
            'documentation' => 'nullable',
        ]+
        ($this->rules());
    }
}
