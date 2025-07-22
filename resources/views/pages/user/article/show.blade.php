<x-user-layout :title="$article->title" :description="Str::limit(strip_tags($article->content), 150)" :show-header="true" :show-footer="true"
    container-class="container-narrow py-12">

    <article>
        {{-- Article Header --}}
        <header class="mb-8 text-center">
            <div class="mb-4">
                <a href="#" class="badge badge-primary text-base">{{ $article->category->name }}</a>
            </div>
            <h1 class="text-4xl md:text-5xl font-extrabold text-neutral-900 mb-4">{{ $article->title }}</h1>
            <div class="flex items-center justify-center space-x-4 text-neutral-500">
                <span>By <a href="#" class="font-medium">{{ $article->author->name }}</a></span>
                <span>&bull;</span>
                <span>{{ $article->published_at->format('F j, Y') }}</span>
            </div>
            @canany(['update', 'delete'], $article)
                <div class="mt-6 flex items-center justify-center space-x-2">
                    @can('update', $article)
                        <a href="{{ route('articles.edit', $article) }}" class="btn btn-outline">Edit Article</a>
                    @endcan
                    @can('delete', $article)
                        <form action="{{ route('articles.destroy', $article) }}" method="POST"
                            onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    @endcan
                </div>
            @endcanany
        </header>

        {{-- Featured Image --}}
        @if ($article->featured_image_url)
            <div class="mb-8">
                <img src="{{ $article->featured_image_url }}" alt="{{ $article->title }}"
                    class="w-full h-auto max-h-[500px] object-cover rounded-lg shadow-lg">
            </div>
        @endif

        {{-- Article Content --}}
        <div class="prose prose-lg max-w-none text-neutral-800 leading-loose">
            {!! $article->content !!}
        </div>

        {{-- Tags --}}
        @if ($article->tags->isNotEmpty())
            <footer class="mt-12 pt-8 border-t border-neutral-200">
                <h4 class="font-semibold text-neutral-700 mb-3">Tags:</h4>
                <div class="flex flex-wrap gap-2">
                    @foreach ($article->tags as $tag)
                        <a href="#" class="badge badge-neutral">{{ $tag->name }}</a>
                    @endforeach
                </div>
            </footer>
        @endif
    </article>

</x-user-layout>
