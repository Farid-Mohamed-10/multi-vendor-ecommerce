@extends('front.master')
@section('title', 'Checkout')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            <h1 class="text-2xl font-bold text-gray-900">Checkout</h1>

            @if (session('error'))
                <div class="mt-4 rounded-xl bg-red-50 p-3 text-sm text-red-700">{{ session('error') }}</div>
            @endif

            @if (session('success'))
                <div class="mt-4 rounded-xl bg-green-50 p-3 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- Summary --}}
                <div class="rounded-2xl border border-gray-200 bg-white p-5">
                    <div class="font-semibold text-gray-900">Order Summary</div>

                    <div class="mt-4 space-y-3 text-sm">
                        @foreach ($items as $item)
                            <div class="flex justify-between gap-4">
                                <div class="text-gray-700">
                                    {{ $item['name'] }}
                                    <span class="text-gray-500">({{ $item['size'] }}/{{ $item['color'] }})</span>
                                    × {{ $item['qty'] }}
                                </div>
                                <div class="font-medium">
                                    ${{ number_format($item['price'] * $item['qty'], 2) }}
                                </div>
                            </div>
                        @endforeach

                        <div class="border-t pt-3 space-y-2">
                            <div class="flex justify-between text-gray-600">
                                <div>Subtotal</div>
                                <div>${{ number_format($subtotal, 2) }}</div>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <div>Tax</div>
                                <div>${{ number_format($tax, 2) }}</div>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <div>Shipping</div>
                                <div>${{ number_format($shipping, 2) }}</div>
                            </div>
                            <div class="border-t pt-2 flex justify-between font-bold text-base text-gray-900">
                                <div>Total</div>
                                <div>${{ number_format($total, 2) }}</div>
                            </div>
                        </div>

                        <div class="text-xs text-gray-500">Payment method: Cash on Delivery</div>
                    </div>
                </div>

                {{-- Form --}}
                <div class="rounded-2xl border border-gray-200 bg-white p-5">
                    <form method="POST" action="{{ route('front.checkout.place') }}" id="checkoutForm" class="space-y-4">
                        @csrf

                        @guest
                            <div>
                                <label class="text-sm font-medium text-gray-700">Email</label>
                                <input name="email" type="email" required
                                    class="mt-1 w-full rounded-xl border border-gray-200 px-3 py-2 text-sm">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        @endguest

                        <div>
                            <label class="text-sm font-medium text-gray-700">Full name</label>
                            <input name="full_name" required
                                class="mt-1 w-full rounded-xl border border-gray-200 px-3 py-2 text-sm">
                            @error('full_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-700">Phone</label>
                            <input name="phone" required
                                class="mt-1 w-full rounded-xl border border-gray-200 px-3 py-2 text-sm">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-700">Address</label>
                            <textarea name="address" required class="mt-1 w-full rounded-xl border border-gray-200 px-3 py-2 text-sm"></textarea>
                            @error('address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="text-sm font-medium text-gray-700">City</label>
                                <input name="city"
                                    class="mt-1 w-full rounded-xl border border-gray-200 px-3 py-2 text-sm">
                                @error('city')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-700">Notes</label>
                                <input name="notes"
                                    class="mt-1 w-full rounded-xl border border-gray-200 px-3 py-2 text-sm">
                                @error('notes')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full rounded-xl bg-gray-900 px-4 py-3 text-sm font-semibold text-white hover:bg-gray-800">
                            Place Order (COD)
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <script>
        // prevent double submit
        document.getElementById('checkoutForm')?.addEventListener('submit', function() {
            const btn = this.querySelector('button[type="submit"]');
            if (btn) {
                btn.disabled = true;
                btn.classList.add('opacity-70', 'cursor-not-allowed');
                btn.textContent = 'Placing order...';
            }
        });
    </script>
@endsection
