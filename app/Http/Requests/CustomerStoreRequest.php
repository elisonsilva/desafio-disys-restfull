<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CustomerStoreRequest extends FormRequest
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
            'name' => 'required|string||regex:/^[\pL\s]+$/u|max:255|min:2',
            'email' => 'required|email|unique:customers',
            'phone' => 'required|string',
            'birthdate' => 'required|date_format:Y-m-d',
            'address' => 'required|string',
            'complement' => 'nullable|string',
            'neighborhood' => 'required|string',
            'zipcode' => 'required|string',
        ];
    }

    /**
     * Failed Validation API
     *
     * @param Validator $validator
     * @return void
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 400));
    }
}
