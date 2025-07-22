<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'category_id' => ['required', Rule::exists('categories', 'id')],
            'tags' => ['nullable', 'array'],
            'tags.*' => [Rule::exists('tags', 'id')],
            'status' => ['nullable', Rule::in(['published', 'draft', 'pending'])],
            'featured_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'excerpt' => ['nullable', 'string', 'max:500'],
        ];
    }
}
