<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PushNotificationTemplateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'message' => 'required',
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
