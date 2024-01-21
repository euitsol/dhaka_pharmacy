<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmailTemplateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'subject' => 'required|min:10',
            'template' => 'required',
        ];
    }

    public function storeRules(): array
    {
        return [
        ]+
        ($this->rules());
    }

    public function updateRules(): array
    {
        return [
        ]+
        ($this->rules());
    }
}
