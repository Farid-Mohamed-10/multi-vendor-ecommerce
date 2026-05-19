@extends('front.master')
@section('title', 'Order Success')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="rounded-2xl border border-gray-200 bg-white p-6">
                <h1 class="text-2xl font-bold text-gray-900">Order placed ✅</h1>
                <p class="mt-2 text-gray-600">
                    Order Number: <span class="font-semibold">{{ $order->order_number }}</span>
                </p>
                <p class="mt-1 text-gray-600">Payment: Cash on Delivery</p>

                <a href="{{ route('front.products') }}"
                    class="mt-6 inline-flex w-full justify-center rounded-xl bg-gray-900 px-4 py-3 text-sm font-semibold text-white hover:bg-gray-800">
                    Continue shopping
                </a>
            </div>
        </div>
    </div>
@endsection
