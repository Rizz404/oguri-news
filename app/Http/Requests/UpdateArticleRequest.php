<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'content' => ['sometimes', 'required', 'string'],
            'category_id' => ['sometimes', 'required', Rule::exists('categories', 'id')],
            'tags' => ['nullable', 'array'],
            'tags.*' => [Rule::exists('tags', 'id')],
            'status' => ['sometimes', 'nullable', Rule::in(['published', 'draft', 'pending'])],
            'featured_image' => ['sometimes', 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }
}
