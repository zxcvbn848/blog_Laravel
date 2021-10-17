<?php

namespace App\Http\Requests\Category;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddCategoryFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'category' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            "category.required" => "Category is required.",
            "category.string" => "Category must be string.",
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $responseData = $validator->errors();
        $response = response()->json($responseData, 400);
        throw new HttpResponseException($response);
    }
}
