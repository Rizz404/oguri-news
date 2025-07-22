<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('articles')
            ->filter(request(['search']))
            ->sort(request('sort_by'), request('direction'))
            ->paginate(12)
            ->withQueryString();

        return view('pages.user.category.index', compact('categories'));
    }

    public function show(Category $category)
    {
        $articles = $category->articles()->where('status', 'published')->latest('published_at')->paginate(10);
        return view('pages.user.category.show', compact('category', 'articles'));
    }
}
