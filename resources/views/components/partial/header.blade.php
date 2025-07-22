@props([
    'sticky' => true,
    'transparent' => false,
])

<header
    class="relative {{ $sticky ? 'sticky top-0 z-40' : '' }} {{ $transparent ? 'bg-transparent' : 'bg-white' }} shadow-sm border-b border-neutral-200 transition-all duration-300"
    x-data="{
        mobileMenuOpen: false,
        scrolled: false,
    }" x-init="window.addEventListener('scroll', () => { scrolled = window.pageYOffset > 10; })"
    :class="{ 'backdrop-blur-md bg-white/90': scrolled && {{ $transparent ? 'true' : 'false' }} }">

    {{-- Main Header --}}
    <div class="container-wide">
        <div class="flex items-center justify-between h-16 lg:h-20">
            {{-- Logo --}}
            <div class="flex items-center">
                <a href="{{ route('landing.index') }}" class="flex items-center space-x-2 group">
                    <div
                        class="w-10 h-10 bg-gradient-primary rounded-full flex items-center justify-center group-hover:scale-105 transition-transform duration-200">
                        <i class="fas fa-cat text-white text-xl"></i>
                    </div>
                    <div class="hidden sm:block">
                        <h1 class="text-xl font-display font-bold text-neutral-900">Oguri News</h1>
                        <p class="text-xs text-neutral-500 -mt-1">Your trusted news</p>
                    </div>
                </a>
            </div>

            {{-- Desktop Navigation --}}
            <nav class="hidden lg:flex items-center space-x-8">
                <a href="{{ route('landing.index') }}"
                    class="nav-link {{ request()->routeIs('landing.index') ? 'nav-link-active' : '' }}">Home</a>
                <a href="{{ route('articles.index') }}"
                    class="nav-link {{ request()->routeIs('articles.*') ? 'nav-link-active' : '' }}">Articles</a>
                <a href="{{ route('categories.index') }}"
                    class="nav-link {{ request()->routeIs('categories.*') ? 'nav-link-active' : '' }}">Categories</a>
                <a href="{{ route('users.index') }}"
                    class="nav-link {{ request()->routeIs('users.*') ? 'nav-link-active' : '' }}">Authors</a>
            </nav>

            {{-- Right Side Actions --}}
            <div class="flex items-center space-x-4">
                @auth
                    {{-- Write Article Button --}}
                    <x-ui.button :href="route('articles.create')" variant="primary" size="sm" class="flex items-center gap-2">
                        <i class="fas fa-pen-to-square"></i>
                        <span class="hidden sm:inline">Write</span>
                    </x-ui.button>

                    {{-- User Menu --}}
                    <div class="relative" x-data="{ userMenuOpen: false }">
                        <button @click="userMenuOpen = !userMenuOpen" class="block" aria-label="Open user menu">
                            <img src="{{ auth()->user()->photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=random' }}"
                                alt="Avatar"
                                class="w-8 h-8 rounded-full object-cover border-2 border-neutral-200 hover:border-primary-500 transition">
                        </button>

                        {{-- Dropdown --}}
                        <div x-show="userMenuOpen" @click.away="userMenuOpen = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg border border-neutral-200 z-50"
                            style="display: none;">
                            <div class="py-1">
                                <div class="px-4 py-3 border-b border-neutral-200">
                                    <p class="text-sm font-medium text-neutral-900 truncate">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-neutral-500 truncate">{{ auth()->user()->email }}</p>
                                </div>
                                <div class="py-1">
                                    <a href="{{ route('profile.edit') }}"
                                        class="block px-4 py-2 text-sm text-neutral-600 hover:bg-neutral-100 hover:text-primary-600">
                                        <i class="fas fa-user fa-fw mr-2"></i>Profile
                                    </a>
                                </div>
                                <div class="py-1 border-t border-neutral-200">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="block w-full text-left px-4 py-2 text-sm text-danger-600 hover:bg-danger-50 hover:text-danger-700 cursor-pointer">
                                            <i class="fas fa-sign-out-alt fa-fw mr-2"></i>Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <x-ui.button :href="route('login')" variant="primary" size="sm">
                        Login
                    </x-ui.button>
                @endauth

                {{-- Mobile Menu Button --}}
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                    class="lg:hidden text-neutral-600 hover:text-primary-600 transition-colors"
                    aria-label="Open main menu">
                    <i class="fas fa-bars text-lg" x-show="!mobileMenuOpen"></i>
                    <i class="fas fa-times text-lg" x-show="mobileMenuOpen" style="display: none;"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="mobileMenuOpen" @click.away="mobileMenuOpen = false" x-transition
        class="lg:hidden border-t border-neutral-200 bg-white" style="display: none;">
        <div class="px-4 py-3 space-y-2">
            <a href="{{ route('landing.index') }}"
                class="block py-2 text-neutral-600 hover:text-primary-600 transition-colors"><i
                    class="fas fa-home fa-fw mr-2"></i>Home</a>
            <a href="{{ route('articles.index') }}"
                class="block py-2 text-neutral-600 hover:text-primary-600 transition-colors"><i
                    class="fas fa-newspaper fa-fw mr-2"></i>Articles</a>
            <a href="{{ route('categories.index') }}"
                class="block py-2 text-neutral-600 hover:text-primary-600 transition-colors"><i
                    class="fas fa-tags fa-fw mr-2"></i>Categories</a>
            <a href="{{ route('users.index') }}"
                class="block py-2 text-neutral-600 hover:text-primary-600 transition-colors"><i
                    class="fas fa-users fa-fw mr-2"></i>Authors</a>
        </div>
    </div>
</header>
