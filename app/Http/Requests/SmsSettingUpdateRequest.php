<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SmsSettingUpdateRequest extends FormRequest
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
            'sms_api_url' => 'required|url',
            'sms_api_key' => 'required',
            'sms_api_secret' => 'nullable',
            'sms_api_status_code' => 'required',
            'sms_api_sender_id' => 'nullable',
        ];
    }
}
