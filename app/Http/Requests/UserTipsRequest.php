<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserTipsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'description' => 'required',
            'products' => 'required',
        ]
            +
            ($this->isMethod('POST') ? $this->store() : $this->update());
    }

    protected function store(): array
    {
        return [
            'image' => 'required|image|mimes:jpeg,png,gif,jpg,webp',

        ];
    }

    protected function update(): array
    {
        return [
            'image' => 'nullable|image|mimes:jpeg,png,gif,jpg,webp',
        ];
    }
}
