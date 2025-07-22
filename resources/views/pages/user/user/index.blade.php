<x-user-layout title="Our Authors" :description="'Discover talented writers from our community.'" :show-header="true" :show-footer="true"
    container-class="container-wide py-12">

    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-neutral-900">Meet Our Authors</h1>
        <p class="mt-2 text-lg text-neutral-600">The creative minds behind the stories you love.</p>
    </div>

    <div class="card mb-8">
        <div class="card-body">
            <form action="{{ route('users.index') }}" method="GET" class="flex items-center gap-4">
                <div class="flex-grow">
                    <x-form.input name="search" :label="false" placeholder="Search authors by name..."
                        :value="request('search')" />
                </div>
                <x-ui.button type="submit">Search</x-ui.button>
            </form>
        </div>
    </div>

    @if ($users->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($users as $user)
                <div class="card text-center p-8 hover:shadow-xl transition-shadow duration-300">
                    <a href="{{ route('users.show', $user) }}">
                        <img src="{{ $user->photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=7F9CF5&background=EBF4FF' }}"
                            alt="{{ $user->name }}" class="w-24 h-24 mx-auto rounded-full object-cover mb-4">
                        <h3 class="text-xl font-bold text-neutral-900 hover:text-primary-600 transition-colors">
                            {{ $user->name }}
                        </h3>
                    </a>
                    @if ($user->profile?->bio)
                        <p class="text-neutral-500 mt-2 text-sm line-clamp-2">
                            {{ $user->profile->bio }}
                        </p>
                    @endif
                    <div class="mt-4 text-sm text-neutral-600 flex justify-center space-x-4">
                        <span><i class="fas fa-file-alt mr-1 text-primary-500"></i> {{ $user->articles_count }}
                            Articles</span>
                        {{-- <span><i class="fas fa-users mr-1 text-secondary-500"></i> 1.2k Followers</span> --}}
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-12">
            {{ $users->links() }}
        </div>
    @else
        <div class="text-center py-16">
            <h2 class="text-xl font-semibold text-neutral-700">No authors found.</h2>
        </div>
    @endif
</x-user-layout>
