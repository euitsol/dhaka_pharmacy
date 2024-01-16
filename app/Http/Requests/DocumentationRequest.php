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
            
        ];
    }

    public function storeRules(): array
    {
        return [
            'documentation' => 'required',
            'title' => 'required|unique:documentations,title',
            'module_key' => 'required|unique:documentations,module_key',
            
        ]+
        ($this->rules());
    }

    public function updateRules($id): array
    {
        return [
            'documentation' => 'nullable',
            'title' => 'required|unique:documentations,title,' . $id,
            'module_key' => 'required|unique:documentations,module_key,' . $id,
        ]+
        ($this->rules());
    }
}
