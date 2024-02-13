<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmittedKycRequest extends FormRequest
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
        ];
    }

    protected function update(): array
    {
        return [
            'note' => 'required',
        ];
    }
}
