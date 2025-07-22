<x-user-layout title="Landing" :description="'Read and discover amazing stories from talented writers around the world. Join our community of readers and writers.'" :keywords="'blog, articles, stories, writers, medium clone, reading'" :show-header="true" :show-footer="true">

    {{-- * Hero Section --}}
    <section class="bg-gradient-to-br from-primary-50 via-white to-secondary-50 py-20">
        <div class="container-wide">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-5xl md:text-6xl font-bold text-neutral-900 mb-6 leading-tight">
                    Where stories
                    <span class="text-primary-600 relative">
                        come alive
                        <svg class="absolute -bottom-2 left-0 w-full h-3 text-primary-200" viewBox="0 0 200 12"
                            fill="currentColor">
                            <path d="M2,8 Q50,2 100,6 T198,4 L198,10 Q100,8 2,12 Z" />
                        </svg>
                    </span>
                </h1>
                <p class="text-xl text-neutral-600 mb-8 leading-relaxed max-w-2xl mx-auto">
                    Discover thought-provoking articles, inspiring stories, and expert insights from writers around the
                    globe.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="#featured" class="btn btn-primary btn-lg px-8 py-4 text-lg">
                        Start Reading
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-outline btn-lg px-8 py-4 text-lg">
                        Join Community
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- * Trending Topics Bar --}}
    <section class="bg-white border-b border-neutral-200 py-4">
        <div class="container-wide">
            <div class="flex flex-wrap items-center gap-4">
                <span class="text-sm font-semibold text-neutral-500 uppercase tracking-wide">Trending:</span>
                @foreach ($categories->take(5) as $category)
                    <a href="{{ route('categories.show', $category) }}"
                        class="inline-flex items-center px-3 py-1 rounded-full bg-neutral-100 hover:bg-primary-100 text-sm font-medium text-neutral-700 hover:text-primary-700 transition-colors">
                        {{ $category->name }}
                        <span class="ml-1 text-xs text-neutral-500">({{ $category->articles_count }})</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- * Featured Articles Section --}}
    <section id="featured" class="py-16 bg-white">
        <div class="container-wide">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-neutral-900 mb-4">Featured Stories</h2>
                <p class="text-lg text-neutral-600">Hand-picked articles from our community</p>
            </div>

            @if ($featuredArticles->count() > 0)
                {{-- * Main Featured Article --}}
                <div class="mb-12">
                    @php $mainArticle = $featuredArticles->first() @endphp
                    <article
                        class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-shadow duration-300">
                        <div class="md:flex">
                            <div class="md:w-1/2">
                                @if ($mainArticle->featured_image_url)
                                    <img src="{{ $mainArticle->featured_image_url }}" alt="{{ $mainArticle->title }}"
                                        class="w-full h-64 md:h-full object-cover">
                                @else
                                    <div
                                        class="w-full h-64 md:h-full bg-gradient-to-br from-primary-100 to-secondary-100 flex items-center justify-center">
                                        <div class="text-center">
                                            <i class="fas fa-newspaper text-4xl text-primary-400 mb-2"></i>
                                            <p class="text-primary-600 font-medium">{{ $mainArticle->category->name }}
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="md:w-1/2 p-8 md:p-12">
                                <div class="flex items-center mb-4">
                                    <span class="badge badge-primary mr-3">{{ $mainArticle->category->name }}</span>
                                    <span
                                        class="text-sm text-neutral-500">{{ $mainArticle->published_at->diffForHumans() }}</span>
                                </div>
                                <h3 class="text-2xl md:text-3xl font-bold text-neutral-900 mb-4 leading-tight">
                                    <a href="{{ route('articles.show', $mainArticle) }}"
                                        class="hover:text-primary-600 transition-colors">
                                        {{ $mainArticle->title }}
                                    </a>
                                </h3>
                                <p class="text-neutral-600 mb-6 leading-relaxed">
                                    {{ $mainArticle->excerpt ?? Str::limit(strip_tags($mainArticle->content), 150) }}
                                </p>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        @if ($mainArticle->author->photo_url)
                                            <img src="{{ $mainArticle->author->photo_url }}"
                                                alt="{{ $mainArticle->author->name }}"
                                                class="w-10 h-10 rounded-full mr-3">
                                        @else
                                            <div
                                                class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center mr-3">
                                                <span class="text-primary-600 font-semibold text-sm">
                                                    {{ substr($mainArticle->author->name, 0, 1) }}
                                                </span>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="font-medium text-neutral-900">{{ $mainArticle->author->name }}
                                            </p>
                                            <p class="text-sm text-neutral-500">
                                                {{ $mainArticle->author->articles_count ?? 0 }} articles</p>
                                        </div>
                                    </div>
                                    <a href="#" class="btn btn-primary">
                                        Read More
                                    </a>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>

                {{-- * Other Featured Articles Grid --}}
                @if ($featuredArticles->count() > 1)
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach ($featuredArticles->skip(1) as $article)
                            <article class="card group hover:scale-105 transition-transform duration-300">
                                @if ($article->featured_image_url)
                                    <img src="{{ $article->featured_image_url }}" alt="{{ $article->title }}"
                                        class="w-full h-48 object-cover">
                                @else
                                    <div
                                        class="w-full h-48 bg-gradient-to-br from-primary-100 to-secondary-100 flex items-center justify-center">
                                        <i class="fas fa-newspaper text-3xl text-primary-400"></i>
                                    </div>
                                @endif

                                <div class="card-body">
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="badge badge-primary">{{ $article->category->name }}</span>
                                        <span
                                            class="text-xs text-neutral-500">{{ $article->published_at->format('M d') }}</span>
                                    </div>
                                    <h4 class="text-lg font-semibold text-neutral-900 mb-2 leading-tight">
                                        <a href="{{ route('articles.show', $article) }}"
                                            class="group-hover:text-primary-600 transition-colors">
                                            {{ Str::limit($article->title, 60) }}
                                        </a>
                                    </h4>
                                    <p class="text-neutral-600 text-sm mb-4">
                                        {{ Str::limit(strip_tags($article->content), 100) }}
                                    </p>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div
                                                class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center mr-2">
                                                <span class="text-primary-600 font-semibold text-xs">
                                                    {{ substr($article->author->name, 0, 1) }}
                                                </span>
                                            </div>
                                            <span
                                                class="text-sm font-medium text-neutral-700">{{ $article->author->name }}</span>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif
            @endif
        </div>
    </section>

    {{-- * Categories Section --}}
    <section class="py-16 bg-neutral-50">
        <div class="container-wide">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-neutral-900 mb-4">Explore Categories</h2>
                <p class="text-lg text-neutral-600">Find stories that match your interests</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-6">
                @foreach ($categories as $category)
                    <a href="{{ route('categories.show', $category) }}"
                        class="group bg-white rounded-lg p-6 text-center hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                        @if ($category->picture_url)
                            <img src="{{ $category->picture_url }}" alt="{{ $category->name }}"
                                class="w-16 h-16 mx-auto mb-4 rounded-full object-cover">
                        @else
                            <div
                                class="w-16 h-16 mx-auto mb-4 rounded-full bg-primary-100 flex items-center justify-center">
                                <i class="fas fa-tag text-primary-600 text-xl"></i>
                            </div>
                        @endif
                        <h3 class="font-semibold text-neutral-900 mb-2 group-hover:text-primary-600 transition-colors">
                            {{ $category->name }}
                        </h3>
                        <p class="text-sm text-neutral-500">{{ $category->articles_count }} articles</p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- * Articles by Category Section --}}
    @if ($articlesByCategory->count() > 0)
        <section class="py-16 bg-white">
            <div class="container-wide">
                @foreach ($articlesByCategory as $category)
                    <div class="mb-16 last:mb-0">
                        <div class="flex items-center justify-between mb-8">
                            <h2 class="text-2xl font-bold text-neutral-900">{{ $category->name }}</h2>
                            <a href="{{ route('categories.index') }}"
                                class="text-primary-600 hover:text-primary-700 font-medium">
                                View all →
                            </a>
                        </div>

                        <div class="grid md:grid-cols-3 gap-6">
                            @foreach ($category->recent_articles as $article)
                                <article class="group">
                                    <div class="flex space-x-4">
                                        @if ($article->featured_image_url)
                                            <img src="{{ $article->featured_image_url }}"
                                                alt="{{ $article->title }}"
                                                class="w-20 h-20 rounded-lg object-cover flex-shrink-0">
                                        @else
                                            <div
                                                class="w-20 h-20 rounded-lg bg-gradient-to-br from-primary-100 to-secondary-100 flex-shrink-0 flex items-center justify-center">
                                                <i class="fas fa-newspaper text-primary-400"></i>
                                            </div>
                                        @endif
                                        <div class="flex-1">
                                            <h4
                                                class="font-semibold text-neutral-900 mb-1 leading-tight group-hover:text-primary-600 transition-colors">
                                                <a href="{{ route('articles.show', $article) }}">
                                                    {{ Str::limit($article->title, 50) }}
                                                </a>
                                            </h4>
                                            <p class="text-sm text-neutral-500 mb-2">{{ $article->author->name }}</p>
                                            <p class="text-xs text-neutral-400">
                                                {{ $article->published_at->format('M d, Y') }}</p>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- * Featured Authors Section --}}
    @if ($featuredAuthors->count() > 0)
        <section class="py-16 bg-neutral-50">
            <div class="container-wide">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-neutral-900 mb-4">Featured Writers</h2>
                    <p class="text-lg text-neutral-600">Discover amazing writers in our community</p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($featuredAuthors as $author)
                        <div
                            class="bg-white rounded-lg p-6 text-center hover:shadow-lg transition-shadow duration-300">
                            @if ($author->photo_url)
                                <img src="{{ $author->photo_url }}" alt="{{ $author->name }}"
                                    class="w-20 h-20 rounded-full mx-auto mb-4 object-cover">
                            @else
                                <div
                                    class="w-20 h-20 rounded-full bg-primary-100 flex items-center justify-center mx-auto mb-4">
                                    <span class="text-primary-600 font-bold text-xl">
                                        {{ substr($author->name, 0, 1) }}
                                    </span>
                                </div>
                            @endif
                            <h3 class="font-semibold text-neutral-900 mb-2">
                                <a href="#" class="hover:text-primary-600 transition-colors">
                                    {{ $author->name }}
                                </a>
                            </h3>
                            @if ($author->profile && $author->profile->bio)
                                <p class="text-sm text-neutral-600 mb-3">
                                    {{ Str::limit($author->profile->bio, 80) }}
                                </p>
                            @endif
                            <div class="flex justify-center space-x-4 text-sm text-neutral-500">
                                <span>{{ $author->articles_count }} articles</span>
                                <span>•</span>
                                <span>{{ $author->followers_count ?? 0 }} followers</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- * Newsletter Section --}}
    <section class="py-16 bg-primary-600">
        <div class="container-wide">
            <div class="max-w-2xl mx-auto text-center text-white">
                <h2 class="text-3xl font-bold mb-4">Stay Updated</h2>
                <p class="text-xl mb-8 text-primary-100">
                    Get the latest stories and updates delivered to your inbox
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center max-w-md mx-auto">
                    <input type="email" placeholder="Enter your email"
                        class="form-input bg-white/10 border-white/20 text-white placeholder-white/70 focus:bg-white/20">
                    <button class="btn bg-white text-primary-600 hover:bg-primary-50 border-0 font-semibold px-8">
                        Subscribe
                    </button>
                </div>
            </div>
        </div>
    </section>

</x-user-layout>
