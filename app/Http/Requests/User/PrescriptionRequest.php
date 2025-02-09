<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Session;

class PrescriptionRequest extends FormRequest
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
            'phone'=>'nullable|numeric|digits:11',
            'instruction'=>'nullable|string|max:1000',
            'uploaded_image'=> 'required|array',
            'uploaded_image.*'=>'required|exists:prescription_images,id',
        ];
    }

    public function messages(): array
    {
        return [
            'phone.numeric' => 'The phone number must be numeric.',
            'phone.digits' => 'The phone number must be 11 digits.',
            'instruction.max' => 'The instruction text must not exceed 1000 characters.',
            'uploaded_image.required' => 'Please upload at least one prescription image.',
            'uploaded_image.array' => 'Something went wrong. Please try again.',
            'uploaded_image.*.required' => 'Prescription image is required.',
            'uploaded_image.*.exists' => 'One or more of the selected prescription images do not exist. Please try again.',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        Session::flash('error', $validator->errors()->first());
        throw new HttpResponseException(redirect()->back()->withInput());
    }
}
