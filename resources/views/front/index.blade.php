@php
    use App\Models\User;
    use App\Models\Product;
    use App\Models\Category;
    $users = User::all();
    $products = Product::all();
    $categories = Category::all();
    $latestProducts = Product::latest()
        ->with(['category', 'stocks'])
        ->limit(4)
        ->get();

    $colorMap = [
        'Blue' => '#3B82F6',
        'Violet' => '#8B5CF6',
        'Black' => '#000000',
        'Gray' => '#9CA3AF',
        'Red' => '#EF4444',
        'Green' => '#10B981',
        'White' => '#FFFFFF',
        'Pink' => '#EC4899',
        'Yellow' => '#F59E0B',
    ];
@endphp

@extends('front.master')
@section('title', 'Home')

@section('content')
    <main class="flex-1 min-w-0 overflow-hidden">
        @include('front.partials.hero-section')

        {{-- Shop by Categories --}}
        <div class="px-6 sm:px-12 py-16 animate-fade-in-up">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-6 mb-12">
                <div class="space-y-1">
                    <h2 class="text-3xl sm:text-4xl font-black text-gray-900 tracking-tight">Shop by Category</h2>
                    <p class="text-gray-500 font-medium text-sm sm:text-base text-center sm:text-left">Explore our curated
                        collections</p>
                </div>
                <a href="{{ route('front.all-categories') }}"
                    class="group inline-flex items-center gap-2 px-8 py-3 bg-gray-900 hover:bg-black text-white font-bold rounded-2xl transition-all duration-300 shadow-xl hover:shadow-gray-200">
                    See All
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
            @if (count($categories))
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
                    @foreach ($categories as $index => $category)
                        <a href="{{ route('front.products', ['category' => $category->id]) }}"
                            class="group bg-white p-6 rounded-[2rem] border border-gray-100 hover:border-purple-200 hover:shadow-[0_20px_40px_rgba(124,58,237,0.08)] transition-all duration-500 text-center animate-fade-in-up"
                            style="animation-delay: {{ ($index % 6) * 100 }}ms">
                            <div
                                class="w-20 h-20 mx-auto rounded-3xl bg-gray-50 flex items-center justify-center mb-4 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500">
                                <img src="{{ $category->image ? Storage::url($category->image) : 'https://via.placeholder.com/128' }}"
                                    alt="{{ $category->name }}" class="w-16 h-16 object-contain">
                            </div>
                            <p class="text-sm font-bold text-gray-900 group-hover:text-purple-600 transition-colors">
                                {{ $category->name }}</p>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="py-20 bg-gray-50 rounded-[3rem] border-2 border-dashed border-gray-200 text-center">
                    <p class="text-gray-400 font-bold uppercase tracking-widest text-sm">No Collections Found</p>
                </div>
            @endif
        </div>

        {{-- Latest Products --}}
        <div
            class="px-6 sm:px-12 py-16 bg-white rounded-[4rem] mx-0 sm:mx-4 shadow-sm border border-gray-50 animate-fade-in-up delay-200">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-6 mb-12">
                <div class="space-y-1">
                    <h2 class="text-3xl sm:text-4xl font-black text-gray-900 tracking-tight">New Arrivals</h2>
                    <p class="text-gray-500 font-medium text-sm sm:text-base text-center sm:text-left">Freshly picked items
                        for you</p>
                </div>
                <a href="{{ route('front.products') }}"
                    class="group inline-flex items-center gap-2 px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-2xl transition-all duration-300 shadow-xl hover:shadow-indigo-200">
                    View Catalog
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
            @if (count($latestProducts))
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach ($latestProducts as $index => $product)
                        <div class="group relative bg-gray-50/50 rounded-[2.5rem] p-4 hover:bg-white hover:shadow-[0_30px_60px_rgba(0,0,0,0.06)] border border-transparent hover:border-gray-100 transition-all duration-500 animate-fade-in-up"
                            style="animation-delay: {{ ($index % 4) * 100 + 300 }}ms">
                            {{-- Image Wrap --}}
                            <div class="relative aspect-[4/5] rounded-[2rem] overflow-hidden mb-6">
                                <img src="{{ $product->image ? Storage::url($product->image) : 'https://via.placeholder.com/300' }}"
                                    alt="{{ $product->name }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">

                                {{-- Hover Overlay --}}
                                <div
                                    class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                    <a href="{{ route('front.show-product', $product) }}"
                                        class="bg-white text-black px-6 py-3 rounded-xl font-bold text-sm shadow-xl transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500 uppercase tracking-widest">
                                        Quick View
                                    </a>
                                </div>

                                @if (!($product->in_stock ?? true))
                                    <span
                                        class="absolute top-4 left-4 px-4 py-1.5 bg-black/80 backdrop-blur-md text-white text-[10px] font-black uppercase tracking-widest rounded-full">Sold
                                        Out</span>
                                @endif
                            </div>

                            {{-- Product Info --}}
                            <div class="px-2 pb-2">
                                <div class="flex justify-between items-start mb-2">
                                    <h3
                                        class="text-lg font-black text-gray-900 group-hover:text-indigo-600 transition-colors truncate pr-2">
                                        {{ $product->name }}</h3>
                                    <span
                                        class="text-lg font-black text-gray-900">${{ number_format($product->price, 2) }}</span>
                                </div>
                                <p class="text-gray-400 text-xs font-medium line-clamp-1 mb-4">
                                    {{ $product->category->name ?? 'General' }}
                                </p>

                                <div class="flex items-center justify-between">
                                    <div class="flex -space-x-1.5 overflow-hidden">
                                        @php
                                            $uniqueColors = $product->stocks->pluck('color')->unique()->take(3);
                                        @endphp
                                        @foreach ($uniqueColors as $colorName)
                                            <div class="w-7 h-7 rounded-full border-2 border-white shadow-sm transition-transform hover:scale-110 cursor-pointer"
                                                title="{{ $colorName }}"
                                                style="background-color: {{ $colorMap[$colorName] ?? '#E2E8F0' }}"></div>
                                        @endforeach
                                        @if ($product->stocks->pluck('color')->unique()->count() > 3)
                                            <div
                                                class="w-7 h-7 rounded-full border-2 border-white bg-gray-50 flex items-center justify-center text-[10px] font-bold text-gray-400">
                                                +{{ $product->stocks->pluck('color')->unique()->count() - 3 }}
                                            </div>
                                        @endif
                                    </div>

                                    @php
                                        $availableStock = $product->stocks->where('quantity', '>', 0)->first();
                                    @endphp
                                    @if ($availableStock)
                                        <form action="{{ route('front.cart.add') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="stock_id" value="{{ $availableStock->id }}">
                                            <input type="hidden" name="qty" value="1">
                                            <button type="submit"
                                                class="w-11 h-11 rounded-2xl bg-gray-900 group-hover:bg-indigo-600 text-white flex items-center justify-center transition-all duration-300 shadow-lg hover:shadow-indigo-200 active:scale-95">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                        d="M12 4v16m8-8H4" />
                                                </svg>
                                            </button>
                                        </form>
                                    @else
                                        <div class="w-11 h-11 rounded-2xl bg-gray-100 text-gray-300 flex items-center justify-center cursor-not-allowed"
                                            title="Out of stock">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M12 4v16m8-8H4" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="py-20 text-center">
                    <p class="text-gray-400 font-bold uppercase tracking-widest text-sm">No New Arrivals</p>
                </div>
            @endif
        </div>
    </main>
@endsection
