@php
    use App\Models\Category;
    $categories = Category::all();
@endphp
<!-- ── TOP BANNER ──────────────────────────────────────── -->
<div
    class="top-banner text-white text-xs sm:text-sm py-2 px-4 sticky top-0 z-50 flex items-center justify-between gap-2">
    <span class="font-semibold tracking-wide truncate">Welcome to Our Lowest Price Store</span>
    <div class="flex items-center gap-1.5 flex-shrink-0">
        <div class="flex items-center gap-2">
            <a href="{{ url('/') }}">Home</a>

            <div class="flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span class="font-medium">{{ Auth::user()->name }}</span>
            </div>
        </div>
    </div>
</div>
<header class="bg-white border-b border-purple-50 sticky top-7 z-40">
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
                class="search-bar w-full px-3 sm:px-4 py-2 sm:py-2.5 pr-9 rounded-xl text-sm text-gray-600 placeholder-gray-400"
                placeholder="Search products, brands and more…">
            <svg class="w-4 h-4 text-gray-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"
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
    </div>

    <!-- Category Nav – scrollable on small screens -->
    <nav
        class="cat-nav flex items-center gap-4 sm:gap-6 px-3 sm:px-6 pb-3 pt-2 border-t border-gray-50 text-xs sm:text-sm text-gray-600 whitespace-nowrap">
        @foreach ($categories as $category)
            <a href="{{ route('admin-dashboard.categories.show', $category) }}"
                class="hover:text-purple-700 transition-colors flex-shrink-0">{{ $category->name }}</a>
        @endforeach

    </nav>
</header>
