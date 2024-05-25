<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DistributionOtpRequest extends FormRequest
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
            'order_distribution_id'=>'required|exists:order_distributions,id',
            'otp_author_id'=>'required',
            'otp_author_type'=>'required',
            'otp'=>'required',
            'rider_id'=>'required|exists:riders,id',
        ];
    }
}
