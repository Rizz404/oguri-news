<x-user-layout title="Explore Categories" :description="'Find stories that match your interests.'" :show-header="true" :show-footer="true"
    container-class="container-wide py-12">

    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-neutral-900">All Categories</h1>
        {{-- @can('create', App\Models\Category::class)
            <x-ui.button :href="route('categories.create')" variant="primary">
                <i class="fas fa-plus mr-2"></i>
                New Category
            </x-ui.button>
        @endcan --}}
    </div>

    <div class="card mb-8">
        <div class="card-body">
            <form action="{{ route('categories.index') }}" method="GET" class="flex items-center gap-4">
                <div class="flex-grow">
                    <x-form.input name="search" :label="false" placeholder="Search categories..."
                        :value="request('search')" />
                </div>
                <x-ui.button type="submit">Filter</x-ui.button>
                <a href="{{ route('categories.index') }}" class="btn btn-ghost" aria-label="Clear filters">
                    <i class="fa-solid fa-xmark"></i>
                </a>
            </form>
        </div>
    </div>

    @if ($categories->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($categories as $category)
                <div class="group relative">
                    <a href="{{ route('categories.show', $category) }}"
                        class="block bg-white rounded-lg p-6 text-center shadow-md hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                        <img src="{{ $category->picture_url ?? 'https://placehold.co/100x100/E2E8F0/4A5568?text=Icon' }}"
                            alt="{{ $category->name }}"
                            class="w-20 h-20 mx-auto mb-4 rounded-full object-cover border-2 border-neutral-200">
                        <h3 class="font-semibold text-neutral-900 mb-2 group-hover:text-primary-600 transition-colors">
                            {{ $category->name }}
                        </h3>
                        <p class="text-sm text-neutral-500">{{ $category->articles_count }} articles</p>
                    </a>
                    {{-- @can('update', $category)
                        <a href="{{ route('categories.edit', $category) }}"
                            class="absolute top-2 right-2 btn btn-sm btn-ghost opacity-0 group-hover:opacity-100 transition-opacity">
                            <i class="fas fa-pencil"></i>
                        </a>
                    @endcan --}}
                </div>
            @endforeach
        </div>
        <div class="mt-12">
            {{ $categories->links() }}
        </div>
    @else
        <div class="text-center py-16">
            <h2 class="text-xl font-semibold text-neutral-700">No categories found.</h2>
        </div>
    @endif
</x-user-layout>
