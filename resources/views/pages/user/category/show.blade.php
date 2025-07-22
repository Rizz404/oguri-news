<x-user-layout :title="$category->name" :description="$category->description" :show-header="true" :show-footer="true"
    container-class="container-wide py-12">

    <div class="text-center mb-12">
        <img src="{{ $category->picture_url ?? 'https://placehold.co/150x150/E2E8F0/4A5568?text=Icon' }}"
            alt="{{ $category->name }}" class="w-24 h-24 mx-auto mb-4 rounded-full object-cover shadow-lg">
        <h1 class="text-4xl font-bold text-neutral-900">{{ $category->name }}</h1>
        @if ($category->description)
            <p class="mt-2 text-lg text-neutral-600 max-w-2xl mx-auto">{{ $category->description }}</p>
        @endif
    </div>

    <h2 class="text-2xl font-bold text-neutral-900 mb-8">Articles in {{ $category->name }}</h2>

    @if ($articles->count() > 0)
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($articles as $article)
                <x-card.category.article :article="$article" />
            @endforeach
        </div>
        <div class="mt-12">
            {{ $articles->links() }}
        </div>
    @else
        <div class="text-center py-16">
            <h2 class="text-xl font-semibold text-neutral-700">No articles in this category yet.</h2>
            <p class="text-neutral-500 mt-2">Check back later for new stories!</p>
        </div>
    @endif
</x-user-layout>
