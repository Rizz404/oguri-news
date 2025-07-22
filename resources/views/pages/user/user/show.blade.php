<x-user-layout :title="$user->name" :description="$user->profile?->bio" :show-header="true" :show-footer="true"
    container-class="container-wide py-12">

    <header class="card mb-12">
        <div class="card-body p-8 md:flex items-center gap-8">
            <img src="{{ $user->photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&size=128&color=7F9CF5&background=EBF4FF' }}"
                alt="{{ $user->name }}" class="w-32 h-32 rounded-full object-cover mx-auto md:mx-0 flex-shrink-0">
            <div class="text-center md:text-left mt-6 md:mt-0">
                <h1 class="text-3xl font-bold text-neutral-900">{{ $user->name }}</h1>
                @if ($user->profile?->bio)
                    <p class="text-neutral-600 mt-2 max-w-xl">{{ $user->profile->bio }}</p>
                @endif
                <div class="mt-4 flex justify-center md:justify-start items-center space-x-6">
                    <div class="text-neutral-700">
                        <span
                            class="font-bold text-lg">{{ $user->articles()->where('status', 'published')->count() }}</span>
                        <span class="text-sm text-neutral-500">Articles</span>
                    </div>
                    {{-- <div class="text-neutral-700">
                        <span class="font-bold text-lg">1.2k</span>
                        <span class="text-sm text-neutral-500">Followers</span>
                    </div> --}}
                    {{-- <x-ui.button variant="secondary" size="sm">Follow</x-ui.button> --}}
                </div>
            </div>
        </div>
    </header>

    <h2 class="text-2xl font-bold text-neutral-900 mb-6">Articles by {{ $user->name }}</h2>

    <div class="card mb-8">
        <div class="card-body">
            <form action="{{ route('users.show', $user) }}" method="GET" class="flex items-center gap-4">
                <div class="flex-grow">
                    <x-form.input name="search" :label="false" placeholder="Search in this author's articles..."
                        :value="request('search')" />
                </div>
                <x-ui.button type="submit">Search</x-ui.button>
            </form>
        </div>
    </div>


    @if ($articles->count() > 0)
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($articles as $article)
                <x-card.user.article :article="$article" />
            @endforeach
        </div>
        <div class="mt-12">
            {{ $articles->links() }}
        </div>
    @else
        <div class="text-center py-16 card">
            <h2 class="text-xl font-semibold text-neutral-700">No articles published by this author yet.</h2>
        </div>
    @endif
</x-user-layout>
