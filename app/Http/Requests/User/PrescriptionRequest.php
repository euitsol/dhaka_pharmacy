<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
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

    protected function prepareForValidation(): void
    {
        // $phone = $this->input('phone');
        // $phone = trim($phone);
        // if (strlen($phone) === 10) {
        //     $phone = '0' . $phone;
        // }
        // $this->merge([
        //     'phone' => $phone,
        // ]);
    }

    public function rules(): array
    {
        return [
            'phone'=>'required|string|digits:11',
            'instruction'=>'nullable|string|max:1000',
            'uploaded_image'=> 'required|array|min:1|max:10',
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
        if ($this->ajax()) {
            throw new HttpResponseException(
                new JsonResponse(['error' => $validator->errors()->first()], 422)
            );
        }

        Session::flash('error', $validator->errors()->first());
        throw new HttpResponseException(redirect()->back()->withInput());
    }
}
