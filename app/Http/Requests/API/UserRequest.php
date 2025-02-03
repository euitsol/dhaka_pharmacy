<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends BaseRequest
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
        $id = $this->user()->id;
        return  [
            'name' => 'sometimes|required|min:4',
            'image' => 'nullable|image|mimes:jpeg,png,gif,jpg,webp',
            'bio' => 'nullable',
            'email' => 'nullable|unique:users,email,' . $id,
            'age' => 'nullable|numeric|digits:2',
            'identification_type' => 'nullable|numeric',
            'identification_no' => 'nullable|numeric',
            'present_address' => 'nullable',
            'gender' => 'nullable|numeric',
            'dob' => 'nullable|date|before:today',
            'father_name' => 'nullable|min:6',
            'mother_name' => 'nullable|min:6',
            'permanent_address' => 'nullable',
        ];
    }
}
