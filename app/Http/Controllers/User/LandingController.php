<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LandingController extends Controller
{
    public function index(): View
    {
        $featuredArticles = Article::with(['author', 'category', 'tags'])
            ->where('status', 'published')
            ->latest('published_at')
            ->take(6)
            ->get();

        $trendingArticles = Article::with(['author', 'category'])
            ->where('status', 'published')
            ->where('published_at', '>=', now()->subDays(7))
            ->latest('published_at')
            ->take(5)
            ->get();

        $publishedArticlesConstraint = function ($query) {
            $query->where('status', 'published');
        };

        // Mengambil kategori yang memiliki artikel berstatus 'published'
        $categories = Category::whereHas('articles', $publishedArticlesConstraint)
            ->withCount(['articles' => $publishedArticlesConstraint])
            ->orderBy('articles_count', 'desc')
            ->take(8)
            ->get();

        $articlesByCategory = $categories->take(3)->map(function ($category) {
            $category->recent_articles = $category->articles()
                ->where('status', 'published')
                ->with('author')
                ->latest('published_at')
                ->take(3)
                ->get();
            return $category;
        });

        // Mengambil author yang memiliki artikel berstatus 'published'
        $featuredAuthors = User::whereHas('articles', $publishedArticlesConstraint)
            ->withCount(['articles' => $publishedArticlesConstraint])
            ->with('profile')
            ->orderBy('articles_count', 'desc')
            ->take(6)
            ->get();

        return view('pages.user.landing.index', compact(
            'featuredArticles',
            'trendingArticles',
            'categories',
            'articlesByCategory',
            'featuredAuthors'
        ));
    }
}
