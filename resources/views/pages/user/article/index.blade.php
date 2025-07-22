<x-user-layout title="Articles" :description="'Discover amazing stories from our talented writers.'" :show-header="true" :show-footer="true"
    container-class="container-wide py-12">

    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-neutral-900">Discover Articles</h1>
        @auth
            <a href="{{ route('articles.create') }}" class="btn btn-primary">
                <i class="fas fa-plus mr-2"></i>
                Create Article
            </a>
        @endauth
    </div>

    {{-- Filter & Search Form --}}
    <div class="card mb-8">
        <div class="card-body">
            <form action="{{ route('articles.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <x-form.input name="search" :label="false" placeholder="Search by title or content..."
                    :value="request('search')" />
                <x-form.input name="category" :label="false" placeholder="Filter by category..." :value="request('category')" />
                <x-form.input name="author" :label="false" placeholder="Filter by author..." :value="request('author')" />
                <div class="flex items-center space-x-2">
                    <button type="submit" class="btn btn-primary w-full">Filter</button>
                    <a href="{{ route('articles.index') }}" class="btn btn-ghost" aria-label="Clear filters">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Articles Grid --}}
    @if ($articles->count() > 0)
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($articles as $article)
                <article class="card group">
                    @if ($article->featured_image_url)
                        <a href="{{ route('articles.show', $article) }}">
                            <img src="{{ $article->featured_image_url }}" alt="{{ $article->title }}"
                                class="w-full h-48 object-cover">
                        </a>
                    @endif
                    <div class="card-body">
                        <div class="mb-3">
                            <span class="badge badge-primary">{{ $article->category->name }}</span>
                        </div>
                        <h4 class="text-lg font-bold text-neutral-900 mb-2 leading-tight">
                            <a href="{{ route('articles.show', $article) }}"
                                class="group-hover:text-primary-600 transition-colors">
                                {{ Str::limit($article->title, 60) }}
                            </a>
                        </h4>
                        <p class="text-neutral-600 text-sm mb-4">
                            {{ $article->excerpt ?? Str::limit(strip_tags($article->content), 100) }}
                        </p>
                        <div class="flex items-center justify-between text-sm text-neutral-500">
                            <div class="flex items-center">
                                <span class="font-medium text-neutral-700">{{ $article->author->name }}</span>
                            </div>
                            <span>{{ $article->published_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                    @canany(['update', 'delete'], $article)
                        <div class="card-footer flex items-center justify-end space-x-2">
                            @can('update', $article)
                                <a href="{{ route('articles.edit', $article) }}" class="btn btn-sm btn-ghost">Edit</a>
                            @endcan
                            @can('delete', $article)
                                <form action="{{ route('articles.destroy', $article) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this article?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            @endcan
                        </div>
                    @endcanany
                </article>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-12">
            {{ $articles->links() }}
        </div>
    @else
        <div class="text-center py-16">
            <h2 class="text-xl font-semibold text-neutral-700">No articles found.</h2>
            <p class="text-neutral-500 mt-2">Try adjusting your filters or check back later.</p>
        </div>
    @endif
</x-user-layout>
