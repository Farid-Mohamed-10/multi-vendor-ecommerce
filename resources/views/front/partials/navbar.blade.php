@php
    use App\Models\Category;

    $categories = Category::all();
@endphp

<header class="sticky top-0 z-50 border-b border-white/20 bg-white/70 shadow-sm backdrop-blur-md">
    <div class="mx-auto flex max-w-7xl items-center gap-4 px-4 py-4 sm:gap-6 sm:px-8">
        <button id="menuBtn" class="rounded-2xl p-2.5 transition-all hover:bg-purple-50 md:hidden flex-shrink-0"
            aria-label="Open menu">
            <svg class="h-6 w-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <a href="{{ url('/') }}" class="group flex flex-shrink-0 items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl transition-transform duration-300 group-hover:rotate-12"
                style="background: var(--primary-gradient)">
                <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
            </div>
            <span class="logo-text text-2xl font-black tracking-tight">ALOSTORA</span>
        </a>

        <form action="{{ route('front.products') }}" method="GET"
            class="relative mx-auto hidden max-w-2xl min-w-0 flex-1 lg:block">
            <input type="text" name="search" value="{{ request('search') }}"
                class="search-bar w-full rounded-2xl border-none bg-gray-100/50 py-3 pl-5 pr-12 text-sm outline-none transition-all focus:bg-white focus:ring-2 focus:ring-purple-500/20"
                placeholder="Search products or categories..." />
            <button type="submit" aria-label="Search"
                class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 transition-colors hover:text-purple-600">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </button>
        </form>

        @if (!auth()->check() || !auth()->user()->hasRole('seller'))
            <a href="{{ route('front.cart.show') }}"
                class="group relative flex-shrink-0 rounded-2xl p-3 transition-all hover:bg-gray-100">
                <svg class="h-6 w-6 text-gray-700 transition-transform group-hover:scale-110" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                @php
                    $cartCount = collect(session('cart.items', []))->sum('qty');
                @endphp
                @if ($cartCount > 0)
                    <span
                        class="absolute right-1 top-1 flex h-5 w-5 items-center justify-center rounded-full bg-pink-500 text-[10px] font-bold text-white ring-2 ring-white">
                        {{ $cartCount }}
                    </span>
                @endif
            </a>
        @endif

        <div class="flex flex-shrink-0 items-center gap-1.5">
            @if (Auth::check())
                <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                    <button @click="open = !open"
                        class="group flex items-center gap-2 rounded-full border border-gray-200 py-1 pl-1 pr-2 transition-all duration-300 hover:border-gray-300 hover:bg-gray-50 focus:border-gray-300 focus:bg-gray-50 focus:outline-none">
                        <div
                            class="flex h-7 w-7 flex-shrink-0 items-center justify-center overflow-hidden rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 text-xs font-bold text-white">
                            @if (Auth::user()->profile_photo_path)
                                <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}"
                                    class="h-full w-full object-cover" alt="">
                            @else
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            @endif
                        </div>

                        <span
                            class="max-w-0 overflow-hidden whitespace-nowrap text-sm font-medium text-gray-700 opacity-0 transition-all duration-300 ease-in-out group-hover:max-w-[120px] group-hover:opacity-100 group-focus:max-w-[120px] group-focus:opacity-100">
                            {{ Auth::user()->name }}
                        </span>

                        <svg class="h-3.5 w-3.5 text-gray-400 transition-transform duration-200"
                            :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="open" x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                        x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                        class="absolute right-0 z-50 mt-2 w-52 overflow-hidden rounded-xl border border-gray-100 bg-white shadow-lg"
                        style="display: none;">
                        <div class="border-b border-gray-100 bg-gradient-to-r from-indigo-50 to-purple-50 px-4 py-3">
                            <div class="flex items-center gap-2.5">
                                <div
                                    class="flex h-9 w-9 flex-shrink-0 items-center justify-center overflow-hidden rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 text-sm font-bold text-white">
                                    @if (Auth::user()->profile_photo_path)
                                        <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}"
                                            class="h-full w-full object-cover" alt="">
                                    @else
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                                    <p class="truncate text-xs text-gray-500">{{ Auth::user()->email }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="py-1.5">
                            @if (Auth::user()->hasRole('admin'))
                                <a href="{{ route('admin-dashboard.index') }}"
                                    class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 transition-colors duration-150 hover:bg-gray-50 hover:text-indigo-600">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                    </svg>
                                    Admin Dashboard
                                </a>
                            @elseif (Auth::user()->hasRole('seller'))
                                <a href="{{ route('seller-dashboard.index') }}"
                                    class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 transition-colors duration-150 hover:bg-gray-50 hover:text-indigo-600">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                    Seller Dashboard
                                </a>
                            @elseif (Auth::user()->hasRole('buyer'))
                                <a href="{{ route('buyer-dashboard.index') }}"
                                    class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 transition-colors duration-150 hover:bg-gray-50 hover:text-indigo-600">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    Buyer Dashboard
                                </a>
                            @endif
                        </div>

                        <div class="my-1 border-t border-gray-100"></div>

                        <div class="py-1.5">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" onclick="return confirm('Are you sure you want to logout?')"
                                    class="flex w-full items-center gap-3 px-4 py-2.5 text-sm text-red-500 transition-colors duration-150 hover:bg-red-50 hover:text-red-600">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <div class="flex items-center gap-2">
                    <a href="{{ route('login') }}"
                        class="px-4 py-1.5 text-sm font-medium text-gray-700 transition-colors duration-150 hover:text-indigo-600">
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                        class="rounded-full bg-indigo-600 px-4 py-1.5 text-sm font-medium text-white transition-colors duration-150 hover:bg-indigo-700">
                        Register
                    </a>
                </div>
            @endif
        </div>
    </div>

    <nav
        class="cat-nav flex items-center gap-4 whitespace-nowrap border-t border-gray-50 px-3 pb-3 pt-2 text-xs text-gray-600 sm:gap-6 sm:px-6 sm:text-sm">
        @foreach ($categories as $category)
            <a href="{{ route('front.products', ['category' => $category->id]) }}"
                class="flex-shrink-0 transition-colors hover:text-purple-700">{{ $category->name }}</a>
        @endforeach
    </nav>
</header>
