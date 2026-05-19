@extends('front.master')
@section('title', 'Cart')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Shopping Cart</h1>
                    <p class="text-sm text-gray-600 mt-1">
                        <span class="font-semibold text-indigo-600">{{ $count }}</span>
                        {{ $count === 1 ? 'item' : 'items' }} in your cart
                    </p>
                </div>
                <a href="{{ route('front.products') }}" class="text-sm text-indigo-600 hover:text-indigo-700">Continue
                    shopping</a>
            </div>

            @if (session('error'))
                <div class="mt-4 rounded-xl bg-red-50 p-3 text-sm text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('success'))
                <div class="mt-4 rounded-xl bg-green-50 p-3 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mt-6 space-y-3">
                @forelse($items as $item)
                    <div class="rounded-2xl border border-gray-200 bg-white p-4 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            @if (!empty($item['image']))
                                <img class="w-16 h-16 rounded-xl object-cover border border-gray-200"
                                    src="{{ asset('storage/' . $item['image']) }}" alt="">
                            @endif

                            <div>
                                <a href="{{ route('front.show-product', $item['slug']) }}"
                                    class="font-semibold text-gray-900 hover:text-indigo-600">
                                    {{ $item['name'] }}
                                </a>
                                <div class="text-sm text-gray-500">Size: {{ $item['size'] }} | Color: {{ $item['color'] }}
                                </div>
                                <div class="text-sm text-gray-500">Price: ${{ number_format($item['price'], 2) }}</div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <form action="{{ route('front.cart.update', $item['stock_id']) }}" method="POST"
                                class="flex items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="qty" value="{{ $item['qty'] }}" min="0"
                                    class="w-20 rounded-xl border border-gray-200 px-3 py-2 text-sm">
                                @error('qty')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <button
                                    class="rounded-xl border border-gray-200 px-3 py-2 text-sm hover:bg-gray-50">Update</button>
                            </form>

                            <form action="{{ route('front.cart.remove', $item['stock_id']) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button
                                    class="rounded-xl bg-red-600 px-3 py-2 text-sm font-semibold text-white hover:bg-red-500">
                                    Remove
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="rounded-2xl border border-gray-200 bg-white p-6 text-gray-600">Cart is empty</div>
                @endforelse
            </div>

            <div class="mt-6 rounded-2xl bg-white border border-gray-200 p-4 flex items-center justify-between">
                <div class="text-lg font-semibold">Subtotal</div>
                <div class="text-lg font-bold">${{ number_format($subtotal, 2) }}</div>
            </div>

            @if ($count > 0)
                <a href="{{ route('front.checkout.show') }}"
                    class="mt-4 inline-flex w-full justify-center rounded-xl bg-gray-900 px-4 py-3 text-sm font-semibold text-white hover:bg-gray-800">
                    Checkout
                </a>
            @endif

        </div>
    </div>
@endsection
