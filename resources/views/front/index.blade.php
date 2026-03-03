@php
    use App\Models\User;
    use App\Models\Product;
    use App\Models\Category;
    $users = User::all();
    $products = Product::all();
    $categories = Category::all();
    $latestProducts = Product::latest()->limit(4)->get();
@endphp

@extends('front.master')
@section('title', 'Home')

@section('content')
    <main class="flex-1 min-w-0 overflow-hidden">
        @include('front.partials.hero-section')

        {{-- Shop by Categories --}}
        <div class="p-10">
            <div class="flex justify-between lg:flex-row md:flex-row flex-col gap-3 items-center mb-7">
                <p class="text-2xl font-bold">Shop by Category</p>
                <a href="{{ route('front.all-categories') }}"
                    class="inline-flex items-center gap-2 px-6 sm:px-8 py-3 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl backdrop-blur-sm">Show
                    all categories</a>
            </div>
            @if (count($categories))
                <div class="flex flex-wrap my-5 gap-4">
                    @foreach ($categories as $category)
                        <div class="p-6 bg-white rounded-xl hover:shadow-xl duration-300">
                            <img src="{{ $category->image ? Storage::url($category->image) : 'https://via.placeholder.com/128' }}"
                                alt="{{ $category->name }}" class="w-24 h-24 rounded-xl">
                            <p class="mt-3 ">{{ $category->name }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <div
                    class="py-12 px-6 bg-gradient-to-br from-slate-50 via-white to-slate-50 rounded-2xl border-2 border-slate-100">
                    <div class="text-center max-w-md mx-auto">
                        <div class="mb-6 flex justify-center">
                            <div
                                class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-slate-200 to-slate-300 rounded-2xl">
                                <svg class="w-8 h-8 text-slate-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">No Categories Yet</h3>
                        <p class="text-gray-600 text-sm mb-6">We're organizing our amazing collection of categories. Check
                            back soon!</p>
                    </div>
                </div>
            @endif
        </div>

        {{-- Latest Products --}}
        <div class="p-10">
            <div class="flex justify-between lg:flex-row md:flex-row flex-col gap-3 items-center mb-7">
                <p class="text-2xl font-bold">Latest Products</p>
                <a href="{{ route('front.all-products') }}"
                    class="inline-flex items-center gap-2 px-6 sm:px-8 py-3 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl backdrop-blur-sm">Show
                    all products</a>
            </div>
            <div>
                @if (count($latestProducts))
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4  gap-6">
                        @foreach ($latestProducts as $product)
                            <div class="p-4">
                                <div
                                    class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                                    <div class="relative h-48 bg-gray-100">
                                        <img src="{{ $product->image ? Storage::url($product->image) : 'https://via.placeholder.com/300' }}"
                                            alt="{{ $product->name }}" class="w-full h-full object-cover">
                                        @if (!($product->in_stock ?? true))
                                            <span
                                                class="absolute top-2 left-2 px-2 py-1 bg-red-500 text-white text-xs rounded-full">Out
                                                of stock</span>
                                        @endif
                                    </div>
                                    <div class="p-4">
                                        <h3 class="text-lg font-semibold text-gray-900 truncate">{{ $product->name }}</h3>
                                        <p class="mt-2 text-gray-700 text-sm line-clamp-2">
                                            {{ Str::limit($product->description, 60) }}</p>
                                        <div class="mt-4 flex items-center justify-between">
                                            <span
                                                class="text-xl font-bold text-purple-600">₹{{ number_format($product->price, 2) }}</span>
                                            <a href="{{ route('front.show-product', $product) }}"
                                                class="inline-flex items-center gap-1 px-3 py-1 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-full transition-colors duration-200">
                                                View
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div
                        class="py-12 px-6 bg-gradient-to-br from-purple-50 via-white to-blue-50 rounded-2xl border-2 border-gray-100 text-center">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">No Products Yet</h3>
                        <p class="text-gray-600">We're adding new items all the time. Check back soon for exciting new
                            arrivals!</p>
                    </div>
                @endif
            </div>
        </div>
    </main>
@endsection
