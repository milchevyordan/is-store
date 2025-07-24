<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title'             => 'required|string|max:255|unique:products,title',
            'image'             => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'category_id'       => 'nullable|exists:categories,id',
            'description'       => 'nullable|string',
            'price'             => 'nullable|numeric',
        ];
    }
}
