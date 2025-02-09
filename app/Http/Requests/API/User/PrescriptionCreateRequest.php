<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\API\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class PrescriptionCreateRequest extends BaseRequest

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
        $this->merge([
            'uploaded_image' => json_decode($this->input('uploaded_image')),
        ]);
    }

    public function rules(): array
    {
        return [
            'phone'=>'nullable|numeric|digits:11',
            'instruction'=>'nullable|string|max:1000',
            'uploaded_image'=> 'required|array|min:1|max:5',
            'uploaded_image.*'=>'required|exists:prescription_images,id,status,0',
        ];
    }

    public function messages(): array
    {
        return [
            'phone.numeric' => 'The phone number must be numeric.',
            'phone.digits' => 'The phone number must be 11 digits.',
            'instruction.max' => 'The instruction text must not exceed 1000 characters.',
            'uploaded_image.required' => 'Please upload at least one prescription image.',
            'uploaded_image.array' => 'Uploaded image must be an array.',
            'uploaded_image.min' => 'Please upload at least one prescription image.',
            'uploaded_image.max' => 'You can upload a maximum of 5 prescription images.',
            'uploaded_image.*.required' => 'Prescription image is required.',
            'uploaded_image.*.exists' => 'One or more of the selected prescription images do not exist or have already been uploaded. Please try again.',
        ];
    }
}
