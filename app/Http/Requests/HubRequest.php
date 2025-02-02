<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HubRequest extends FormRequest
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
            'description' => 'required|string',
        ]
            +
            ($this->isMethod('POST') ? $this->store() : $this->update());
    }

    protected function store(): array
    {
        return [
            'name' => 'required|unique:hubs,name',
            'slug' => 'required|unique:hubs,slug',

        ];
    }

    protected function update(): array
    {
        return [
            'name' => 'required|unique:hubs,name,' . $this->route('id'),
            'slug' => 'required|unique:hubs,slug,' . $this->route('id'),
        ];
    }
}
