@props(['article'])

<article class="card group flex flex-col">
    @if ($article->featured_image_url)
        <a href="{{ route('articles.show', $article) }}">
            <img src="{{ $article->featured_image_url }}" alt="{{ $article->title }}" class="w-full h-48 object-cover">
        </a>
    @endif
    <div class="card-body flex-grow flex flex-col">
        <div class="mb-3">
            <span class="badge badge-primary">{{ $article->category->name }}</span>
        </div>
        <h4 class="text-lg font-bold text-neutral-900 mb-2 leading-tight flex-grow">
            <a href="{{ route('articles.show', $article) }}" class="group-hover:text-primary-600 transition-colors">
                {{ Str::limit($article->title, 60) }}
            </a>
        </h4>
        <div class="mt-4 flex items-center justify-between text-sm text-neutral-500">
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
                    onsubmit="return confirm('Are you sure?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            @endcan
        </div>
    @endcanany
</article>
