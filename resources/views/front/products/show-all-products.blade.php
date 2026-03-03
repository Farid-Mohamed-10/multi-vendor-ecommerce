@extends('front.master')
@section('title', 'All Products')

@section('content')

    <div class="min-h-screen bg-gray-50">

        {{-- Page Header --}}
        <div class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">All Products</h1>
                        <p class="text-sm text-gray-500 mt-1">
                            Showing <span
                                class="font-medium text-gray-700">{{ $products->total() ?? $products->count() }}</span>
                            results
                        </p>
                    </div>

                    {{-- Search Bar --}}
                    <form method="GET" action="{{ route('front.products') }}"
                        class="flex items-center gap-2 w-full sm:w-auto">
                        <div class="relative flex-1 sm:w-72">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search products..."
                                class="w-full pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-gray-50" />
                        </div>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition-colors duration-150">
                            Search
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex gap-8">

                {{-- ======= SIDEBAR FILTERS ======= --}}
                <aside class="hidden lg:block w-64 flex-shrink-0">
                    <form method="GET" action="{{ route('front.products') }}" id="filter-form">

                        {{-- Categories --}}
                        <div class="bg-white rounded-xl border border-gray-200 p-5 mb-4">
                            <h3 class="text-sm font-semibold text-gray-900 mb-3">Category</h3>
                            <div class="space-y-2">
                                <label class="flex items-center gap-2.5 cursor-pointer group">
                                    <input type="radio" name="category" value=""
                                        {{ !request('category') ? 'checked' : '' }}
                                        class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500"
                                        onchange="document.getElementById('filter-form').submit()" />
                                    <span class="text-sm text-gray-600 group-hover:text-gray-900">All Categories</span>
                                </label>
                                @foreach ($categories ?? [] as $category)
                                    <label class="flex items-center gap-2.5 cursor-pointer group">
                                        <input type="radio" name="category" value="{{ $category->id }}"
                                            {{ request('category') == $category->id ? 'checked' : '' }}
                                            class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500"
                                            onchange="document.getElementById('filter-form').submit()" />
                                        <span
                                            class="text-sm text-gray-600 group-hover:text-gray-900">{{ $category->name }}</span>
                                        <span
                                            class="ml-auto text-xs text-gray-400">{{ $category->products_count ?? '' }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Price Range --}}
                        <div class="bg-white rounded-xl border border-gray-200 p-5 mb-4">
                            <h3 class="text-sm font-semibold text-gray-900 mb-3">Price Range</h3>
                            <div class="flex items-center gap-2">
                                <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min"
                                    class="w-full px-3 py-1.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                                <span class="text-gray-400 text-sm">–</span>
                                <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max"
                                    class="w-full px-3 py-1.5 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                            </div>
                            <button type="submit"
                                class="mt-3 w-full py-1.5 text-sm font-medium text-indigo-600 border border-indigo-200 hover:bg-indigo-50 rounded-lg transition-colors duration-150">
                                Apply
                            </button>
                        </div>

                        {{-- Sort --}}
                        <div class="bg-white rounded-xl border border-gray-200 p-5">
                            <h3 class="text-sm font-semibold text-gray-900 mb-3">Sort By</h3>
                            <div class="space-y-2">
                                @foreach ([
            'latest' => 'Latest',
            'oldest' => 'Oldest',
            'price_asc' => 'Price: Low to High',
            'price_desc' => 'Price: High to Low',
        ] as $value => $label)
                                    <label class="flex items-center gap-2.5 cursor-pointer group">
                                        <input type="radio" name="sort" value="{{ $value }}"
                                            {{ request('sort', 'latest') === $value ? 'checked' : '' }}
                                            class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500"
                                            onchange="document.getElementById('filter-form').submit()" />
                                        <span
                                            class="text-sm text-gray-600 group-hover:text-gray-900">{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Size Filter --}}
                        <div class="bg-white rounded-xl border border-gray-200 p-5 my-4">
                            <h3 class="text-sm font-semibold text-gray-900 mb-3">Size</h3>
                            <div class="space-y-2">
                                <label class="flex items-center gap-2.5 cursor-pointer group">
                                    <input type="radio" name="size" value=""
                                        {{ !request('size') ? 'checked' : '' }}
                                        class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500"
                                        onchange="document.getElementById('filter-form').submit()" />
                                    <span class="text-sm text-gray-600 group-hover:text-gray-900">All Sizes</span>
                                </label>
                                @foreach ($sizes ?? [] as $size)
                                    <label class="flex items-center gap-2.5 cursor-pointer group">
                                        <input type="radio" name="size" value="{{ $size }}"
                                            {{ request('size') == $size ? 'checked' : '' }}
                                            class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500"
                                            onchange="document.getElementById('filter-form').submit()" />
                                        <span
                                            class="text-sm text-gray-600 group-hover:text-gray-900">{{ $size }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Preserve search across filters --}}
                        @if (request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif

                    </form>

                    {{-- Clear Filters --}}
                    @if (request()->hasAny(['category', 'size', 'min_price', 'max_price', 'sort', 'search']))
                        <a href="{{ route('front.products') }}"
                            class="mt-3 w-full flex items-center justify-center gap-1.5 py-2 text-sm text-red-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-150">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Clear all filters
                        </a>
                    @endif
                </aside>

                {{-- ======= PRODUCTS GRID ======= --}}
                <div class="flex-1 min-w-0">

                    {{-- Active Filters Chips --}}
                    @if (request()->hasAny(['category', 'size', 'min_price', 'max_price', 'search']))
                        <div class="flex flex-wrap gap-2 mb-4">
                            @if (request('search'))
                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-100">
                                    Search: {{ request('search') }}
                                    <a href="{{ request()->fullUrlWithoutQuery(['search']) }}"
                                        class="hover:text-indigo-900">✕</a>
                                </span>
                            @endif
                            @if (request('size'))
                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-100">
                                    Size: {{ request('size') }}
                                    <a href="{{ request()->fullUrlWithoutQuery(['size']) }}"
                                        class="hover:text-indigo-900">✕</a>
                                </span>
                            @endif
                            @if (request('min_price') || request('max_price'))
                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-100">
                                    Price: {{ request('min_price', '0') }} – {{ request('max_price', '∞') }}
                                    <a href="{{ request()->fullUrlWithoutQuery(['min_price', 'max_price']) }}"
                                        class="hover:text-indigo-900">✕</a>
                                </span>
                            @endif
                        </div>
                    @endif

                    {{-- Empty State --}}
                    @if ($products->isEmpty())
                        <div class="flex flex-col items-center justify-center py-24 text-center">
                            <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                            </div>
                            <h3 class="text-base font-semibold text-gray-900 mb-1">No products found</h3>
                            <p class="text-sm text-gray-500 mb-4">Try adjusting your search or filters.</p>
                            <a href="{{ route('front.products') }}"
                                class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition-colors">
                                Clear filters
                            </a>
                        </div>
                    @else
                        {{-- Grid --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
                            @foreach ($products as $product)
                                <div
                                    class="group bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-md hover:border-gray-300 transition-all duration-200 flex flex-col">

                                    {{-- Product Image --}}
                                    <a href="{{ route('front.show-product', $product->slug) }}"
                                        class="relative overflow-hidden bg-gray-100 aspect-[4/3] block">
                                        @if ($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}"
                                                alt="{{ $product->name }}"
                                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.5"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif

                                        {{-- Category Badge --}}
                                        @if ($product->category)
                                            <span
                                                class="absolute top-2.5 left-2.5 px-2 py-0.5 text-xs font-medium bg-white/90 backdrop-blur-sm text-gray-700 rounded-full border border-gray-200">
                                                {{ $product->category->name }}
                                            </span>
                                        @endif
                                    </a>

                                    {{-- Product Info --}}
                                    <div class="p-4 flex flex-col flex-1">
                                        <a href="{{ route('front.show-product', $product->slug) }}"
                                            class="text-sm font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors line-clamp-2 mb-1 hover:underline">
                                            {{ $product->name }}
                                        </a>

                                        @if ($product->description)
                                            <p class="text-xs text-gray-500 line-clamp-2 mb-3">
                                                {{ $product->description }}
                                            </p>
                                        @endif

                                        {{-- Price and Action --}}
                                        <div class="mt-auto flex items-center justify-between gap-2">
                                            <span class="text-base font-bold text-gray-900">
                                                ${{ number_format($product->price, 2) }}
                                            </span>

                                            <a href="{{ route('front.show-product', $product->slug) }}"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-lg transition-colors duration-150 whitespace-nowrap">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                View
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Pagination --}}
                        @if ($products->hasPages())
                            <div class="mt-8 flex justify-center">
                                {{ $products->withQueryString()->links() }}
                            </div>
                        @endif
                    @endif

                </div>
            </div>
        </div>

    </div>

@endsection
