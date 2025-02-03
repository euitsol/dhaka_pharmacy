<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MedicineDosesRequest extends FormRequest
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
            'icon' => 'nullable|image|mimes:jpeg,png,gif,jpg,webp',
            'description' => 'nullable|string',
        ]
            +
            ($this->isMethod('POST') ? $this->store() : $this->update());
    }

    protected function store(): array
    {
        return [
            'name' => 'required|unique:medicine_doses,name',
            'slug' => 'required|unique:medicine_doses,slug',

        ];
    }

    protected function update(): array
    {
        return [
            'name' => 'required|unique:medicine_doses,name,' . $this->route('id'),
            'slug' => 'required|unique:medicine_doses,slug,' . $this->route('id'),
        ];
    }
}
