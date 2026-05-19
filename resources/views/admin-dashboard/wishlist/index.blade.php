@extends('admin-dashboard.master')
@section('title', 'Admin Wishlist')
@section('wishlist active', 'active')

@section('content')
    <div class="p-4 sm:p-6 lg:p-8">

        <div class="flex items-center justify-between mb-6 flex-wrap gap-3">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-800">My Wishlist</h1>
                <p class="text-sm text-gray-400 mt-0.5">Admin's saved products for later</p>
            </div>
        </div>

        {{-- Flash --}}
        @if (session('success'))
            <div
                class="flex items-center gap-3 bg-green-50 border border-green-100 text-green-700 text-sm px-4 py-3 rounded-xl mb-5">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if ($wishlists->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($wishlists as $wish)
                    @php $product = $wish->product; @endphp
                    @if ($product)
                        <div class="bg-white rounded-2xl overflow-hidden group transition-all hover:shadow-lg"
                            style="box-shadow:0 2px 12px rgba(139,92,246,0.07)">
                            {{-- Product Image --}}
                            <div class="relative aspect-[4/3] bg-gray-100 overflow-hidden">
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif

                                {{-- Remove button --}}
                                <form action="{{ route('wishlist.toggle', $product) }}" method="POST"
                                    class="absolute top-2 right-2">
                                    @csrf
                                    <button type="submit"
                                        class="p-2 rounded-full bg-white/90 text-red-500 hover:bg-red-50 hover:text-red-600 transition-colors shadow-sm"
                                        title="Remove from Wishlist">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                                        </svg>
                                    </button>
                                </form>
                            </div>

                            {{-- Product Info --}}
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-800 text-sm truncate mb-1">{{ $product->name }}</h3>
                                <p class="text-xs text-gray-400 mb-3">{{ $product->category->name ?? '' }}</p>

                                <div class="flex items-center justify-between">
                                    <span
                                        class="text-lg font-bold text-indigo-600">${{ number_format($product->price, 2) }}</span>
                                    <a href="{{ route('front.show-product', $product) }}"
                                        class="px-3 py-1.5 rounded-lg text-xs font-semibold text-indigo-600 border border-indigo-200 hover:bg-indigo-50 hover:border-indigo-300 transition-colors">
                                        View Product
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            @if ($wishlists->hasPages())
                <div class="mt-6">
                    {{ $wishlists->links() }}
                </div>
            @endif
        @else
            <div class="bg-white rounded-2xl p-16 text-center" style="box-shadow:0 2px 12px rgba(139,92,246,0.07)">
                <div class="flex flex-col items-center gap-3">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center bg-indigo-50">
                        <svg class="w-6 h-6 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                        </svg>
                    </div>
                    <p class="text-gray-400 text-sm font-medium">Your wishlist is empty</p>
                    <a href="{{ route('front.products') }}" class="text-xs text-indigo-600 font-semibold hover:underline">
                        Browse products →
                    </a>
                </div>
            </div>
        @endif

    </div>
@endsection
