<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class HubAssignRequest extends FormRequest
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
            'order_id' => decrypt($this->input('order_id')),
        ]);
    }
    public function rules(): array
    {
        return [
            'order_id' => 'required|exists:orders,id',
            'data' => 'required|array',
            'data.*.p_id' => 'required|exists:medicines,id',
            'data.*.hub_id' => 'required|exists:hubs,id',
            'note' => 'nullable|string|max:5000',
        ];
    }
}
