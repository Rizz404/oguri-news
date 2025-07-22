<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $articles = Article::with(['author:id,name', 'category:id,name'])
            ->where('status', 'published')
            ->filter($request->only('search', 'category', 'author', 'tag'))
            ->sort($request->input('sort_by'), $request->input('direction'))
            ->paginate(12) // * Mungkin lebih baik 12 untuk grid 3 kolom
            ->withQueryString();

        return view('pages.user.article.index', compact('articles'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();
        return view('pages.user.article.create', compact('categories', 'tags'));
    }

    public function store(StoreArticleRequest $request)
    {
        // Cast ke Request untuk IDE
        /** @var \Illuminate\Http\Request $request */
        $validated = $request->validated();
        $imageUrl = null;

        if ($request->filled('featured_image') && $request->file('featured_image')) {
            $uploadedFile = $request->file('featured_image');
            $path = $uploadedFile->store('articles', 'public');
            $imageUrl = Storage::url($path);
        }


        $articleData = array_merge($validated, [
            'user_id' => Auth::id(),
            'slug' => Str::slug($validated['title']) . '-' . Str::lower(Str::random(6)),
            'published_at' => ($validated['status'] ?? 'draft') === 'published' ? Carbon::now() : null,
            'featured_image_url' => $imageUrl,
        ]);

        $article = Article::create($articleData);

        // Sinkronisasi tags setelah artikel dibuat
        if ($request->filled('tags')) {
            $article->tags()->sync($validated['tags']);
        }

        return redirect()->route('articles.show', $article)->with('success', 'Article created successfully!');
    }

    public function show(Article $article)
    {
        if ($article->status !== 'published' && (Auth::guest() || Auth::id() !== $article->user_id)) {
            abort(404);
        }

        $article->load(['author', 'category', 'tags']);
        return view('pages.user.article.show', compact('article'));
    }

    public function edit(Article $article)
    {
        $categories = Category::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();
        // Muat tag yang sudah terpilih untuk artikel ini
        $article->load('tags');
        return view('pages.user.article.edit', compact('article', 'categories', 'tags'));
    }

    public function update(UpdateArticleRequest $request, Article $article)
    {
        // Cast ke Request untuk IDE
        /** @var \Illuminate\Http\Request $request */

        $validated = $request->validated();

        if ($request->hasFile('featured_image')) {
            // Hapus gambar lama jika ada
            if ($article->featured_image_url) {
                $oldPath = str_replace(Storage::url(''), '', $article->featured_image_url);
                Storage::disk('public')->delete($oldPath);
            }

            // Simpan gambar baru
            $path = $request->file('featured_image')->store('articles', 'public');
            $validated['featured_image_url'] = Storage::url($path);
        }

        if (isset($validated['title']) && $validated['title'] !== $article->title) {
            $validated['slug'] = Str::slug($validated['title']) . '-' . Str::lower(Str::random(6));
        }

        if (isset($validated['status']) && $validated['status'] === 'published' && is_null($article->published_at)) {
            $validated['published_at'] = Carbon::now();
        }

        $article->update($validated);

        // Sinkronisasi tags setelah artikel diperbarui
        if ($request->has('tags')) {
            $article->tags()->sync($request->validated()['tags'] ?? []);
        } else {
            $article->tags()->detach(); // Hapus semua tag jika input kosong
        }

        return redirect()->route('articles.show', $article)->with('success', 'Article updated successfully!');
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('articles.index')->with('success', 'Article deleted successfully!');
    }
}
