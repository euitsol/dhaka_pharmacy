<?php

namespace App\Http\Requests\LocalAreaManager;

use Illuminate\Foundation\Http\FormRequest;

class EarningReportRequest extends FormRequest
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
            'from_date' => 'required|date|before:today',
            'to_date' => 'required|date|before_or_equal:today',
        ];
    }
}