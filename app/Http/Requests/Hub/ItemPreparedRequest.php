<?php

namespace App\Http\Requests\Hub;

use Illuminate\Foundation\Http\FormRequest;

class ItemPreparedRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'order_id' => decrypt($this->order_id),
        ]);
    }
    public function rules(): array
    {
        return [
            'order_id' => ['required', 'exists:orders,id'],
        ];
    }
}
