@php
    use App\Models\Category;
    $categories = Category::all();
@endphp
<!-- ── TOP BANNER ──────────────────────────────────────── -->
<header class="bg-white border-b border-purple-50 sticky z-40">
    <div class="flex items-center px-3 sm:px-6 py-3 gap-3 sm:gap-5">
        <!-- Hamburger (mobile only) -->
        <button id="menuBtn" class="md:hidden p-2 rounded-xl hover:bg-purple-50 transition-colors flex-shrink-0"
            aria-label="Open menu">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <!-- Logo -->
        <a href="{{ url('/') }}" class="flex items-center gap-2 flex-shrink-0">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                style="background:linear-gradient(135deg,#7C3AED,#EC4899)">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
            </div>
            <span class="text-xl sm:text-2xl font-extrabold logo-text">E-Commerce</span>
        </a>

        <!-- Search -->
        <div class="flex-1 relative min-w-0">
            <input
                class="search-bar w-[80%] px-3 sm:px-4 py-2 sm:py-2.5 pr-9 rounded-xl text-sm text-gray-600 placeholder-gray-400"
                placeholder="Search products, brands and more…" />
            <svg class="w-4 h-4 text-gray-400 absolute right-[22%] top-1/2 -translate-y-1/2 pointer-events-none"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>

        <!-- Cart -->
        <button class="relative p-2 rounded-xl hover:bg-purple-50 transition-colors flex-shrink-0">
            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <span
                class="absolute -top-1 -right-1 w-4 h-4 bg-pink-500 text-white text-xs rounded-full flex items-center justify-center font-bold">3</span>
        </button>

        {{-- User Dropdown Menu --}}
        <div class="flex items-center gap-1.5 flex-shrink-0">
            @if (Auth::check())
                {{-- Authenticated User Dropdown --}}
                <div class="relative" x-data="{ open: false }" @click.outside="open = false">

                    {{-- Trigger Button --}}
                    <button @click="open = !open"
                        class="flex items-center gap-2 pl-1 pr-2 py-1 rounded-full border border-gray-200 hover:border-gray-300 hover:bg-gray-50 focus:border-gray-300 focus:bg-gray-50 transition-all duration-300 group focus:outline-none">
                        {{-- Avatar Icon --}}
                        <div
                            class="w-7 h-7 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>

                        {{-- User Name — hidden by default, shown on hover/focus --}}
                        <span
                            class="font-medium text-sm text-gray-700 max-w-0 overflow-hidden whitespace-nowrap opacity-0 group-hover:max-w-[120px] group-hover:opacity-100 group-focus:max-w-[120px] group-focus:opacity-100 transition-all duration-300 ease-in-out">
                            {{ Auth::user()->name }}
                        </span>

                        {{-- Chevron --}}
                        <svg class="w-3.5 h-3.5 text-gray-400 transition-transform duration-200"
                            :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    {{-- Dropdown Panel --}}
                    <div x-show="open" x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                        x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                        class="absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden z-50"
                        style="display: none;">
                        {{-- User Info Header --}}
                        <div class="px-4 py-3 bg-gradient-to-r from-indigo-50 to-purple-50 border-b border-gray-100">
                            <div class="flex items-center gap-2.5">
                                <div
                                    class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-gray-800 truncate">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Menu Items --}}
                        <div class="py-1.5">

                            {{-- Dashboard Link --}}
                            @if (Auth::user()->hasRole('admin'))
                                <a href="{{ route('admin-dashboard.index') }}"
                                    class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-indigo-600 transition-colors duration-150">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                    </svg>
                                    Admin Dashboard
                                </a>
                            @elseif (Auth::user()->hasRole('seller'))
                                <a href="{{ route('seller-dashboard.index') }}"
                                    class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-indigo-600 transition-colors duration-150">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                    Seller Dashboard
                                </a>
                            @elseif (Auth::user()->hasRole('buyer'))
                                <a href="{{ route('buyer-dashboard.index') }}"
                                    class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-indigo-600 transition-colors duration-150">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    Buyer Dashboard
                                </a>
                            @endif

                        </div>

                        {{-- Divider --}}
                        <div class="border-t border-gray-100 my-1"></div>

                        {{-- Logout --}}
                        <div class="py-1.5">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" onclick="return confirm('Are you sure you want to logout?')"
                                    class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 hover:text-red-600 transition-colors duration-150">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                {{-- Guest Buttons --}}
                <div class="flex items-center gap-2">
                    <a href="{{ route('login') }}"
                        class="px-4 py-1.5 text-sm font-medium text-gray-700 hover:text-indigo-600 transition-colors duration-150">
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                        class="px-4 py-1.5 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-full transition-colors duration-150">
                        Register
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Category Nav – scrollable on small screens -->
    <nav
        class="cat-nav flex items-center gap-4 sm:gap-6 px-3 sm:px-6 pb-3 pt-2 border-t border-gray-50 text-xs sm:text-sm text-gray-600 whitespace-nowrap">
        @foreach ($categories as $category)
            <p class="hover:text-purple-700 transition-colors flex-shrink-0">{{ $category->name }}</p>
        @endforeach

    </nav>
</header>
