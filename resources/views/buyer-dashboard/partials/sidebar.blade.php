<aside class="sidebar w-64 flex-shrink-0 p-5 flex flex-col gap-7" id="sidebar" style="min-height:calc(100vh - 88px)">
    <!-- Close btn – mobile only -->
    <div class="flex items-center justify-between md:hidden pt-1">
        <span class="text-sm font-bold text-gray-700">Menu</span>
        <button id="closeBtn" class="p-1.5 rounded-lg hover:bg-purple-50">
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Buyer Profile -->
    <div class="flex items-center gap-3 fade-up">
        <div class="w-11 h-11 rounded-2xl flex items-center justify-center flex-shrink-0"
            style="background:linear-gradient(135deg,#EDE9FE,#DDD6FE)">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
            </svg>
        </div>
        <div class="min-w-0">
            <p class="text-xs text-gray-400 font-medium">{{ Str::upper(auth()->user()->roles->first()->name) }}</p>
            <p class="text-sm font-bold text-gray-800 truncate">{{ Auth::user()->name }}</p>
        </div>
    </div>

    <!-- Nav links -->
    <nav class="flex flex-col gap-1 fade-up d1">
        <a href="{{ route('buyer-dashboard.index') }}"
            class="nav-item @yield('my orders active') flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
            </svg>My Orders
        </a>
        <a href="#" class="nav-item flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
            </svg>Profile
        </a>
        <a href="#" class="nav-item flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
            </svg>Wishlist
        </a>
        <div class="mt-3 pt-3 border-t border-purple-50">
            <div
                class="nav-item flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm text-red-500 hover:bg-red-50 hover:text-red-600">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </div>
        </div>
    </nav>
</aside>
