<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterFormRequest extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "Name is required.",
            "name.string" => "Name must be string.",
            "email.required" => 'Email is required.',
            "email.email" => "Form of Email must be correct.",
            "password.required" => "Password is required.",
            "confirm_password.required" => "Confirm_Password is required.",
            'confirm_password.same:password' => 'Confirm_Password must be same as Password.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $responseData = $validator->errors();
        $response = response()->json($responseData, 400);
        throw new HttpResponseException($response);
    }
}
