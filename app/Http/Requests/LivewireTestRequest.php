<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LivewireTestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|max:20',
        ];
    }

    public function storeRules(): array
    {
        return [
            'roll' => 'required|integer|unique:livewire_tests,roll|digits:6',
        ]+
        ($this->rules());
    }

    public function updateRules($id): array
    {
        return [
            'roll' => 'required|integer|digits:6|unique:livewire_tests,roll,'.$id,
        ]+
        ($this->rules());
    }
}
