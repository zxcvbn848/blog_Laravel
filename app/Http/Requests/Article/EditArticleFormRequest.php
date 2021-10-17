<?php

namespace App\Http\Requests\Article;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class EditArticleFormRequest extends FormRequest
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
            'title' => 'sometimes|required|string',
            'article' => 'sometimes|required|string',
            'category' => 'sometimes|required|string',
            'tags' => 'sometimes|required|array',
            'tags.*' => 'sometimes|required|string',
        ];
    }

    public function messages()
    {
        return [
            "title.required" => "Title is required.",
            "title.string" => "Title must be string.",
            "article.required" => 'Article is required.',
            "article.string" => "Article must be string.",
            "category.required" => "Category is required.",
            "category.string" => "Category must be string.",
            'tags.required' => 'Tags are required.',
            "tags.*.required" => "Tags are required.",
            "tags.*.string" => "Tags must be string.",
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $responseData = $validator->errors();
        $response = response()->json($responseData, 400);
        throw new HttpResponseException($response);
    }
}
