<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->hasAnyRole(['superadmin']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'code' => 'required|unique:items,code,'.$this->item->id,
            'name' => 'required',
            'unit' => 'required',
            'category' => 'required',
            'description' => 'required',
            'initial_stock' => 'required|numeric',
            'current_stock' => 'required|numeric',
            'location_id' => 'required',
            'image' => 'sometimes|mimes:png,jpg,jpeg',
        ];
    }
}
