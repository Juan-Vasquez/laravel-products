<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'code_product' => 'required|unique:products|min:3|max:10',
            'name_product' => 'required|min:3|max:100',
            'quantity' => 'required|integer|min:1|max:100',
            'photo_product' => 'required',
            'price' => 'required|min:0.01|max:10000',
            'currency' => 'required',
            'entry_date' => 'required|date',
            'expiration_date' => 'required|date',
        ];
    }
}
