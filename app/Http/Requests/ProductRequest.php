<?php

namespace App\Http\Requests;

use App\Rules\base64image;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
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
            'code_product' => [
                'required',
                'min:3',
                Rule::unique('products')->ignore($this->route('product')),
            ],
            'name_product' => 'required|min:3|max:100',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|min:0.01',
            'currency' => 'required',
            'entry_date' => 'required|date',
            'expiration_date' => 'required|date',
            'photo_product' => ['nullable', new base64image()],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            $dateExpiration = Carbon::parse($this->input('expiration_date'));
            $entryDate = Carbon::parse($this->input('entry_date'));

            if( $entryDate->gt($dateExpiration) ){

                $validator->errors()->add('entry_date', 'La fecha de ingreso no puede ser mayor a la de vencimiento');

            }

        });
    }
}
