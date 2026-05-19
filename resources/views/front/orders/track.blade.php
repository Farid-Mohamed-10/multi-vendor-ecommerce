@extends('front.master')

@section('title', 'Track Order')

@section('content')
    <section class="min-h-screen bg-slate-50 px-6 py-16 sm:px-10 lg:px-16">
        <div class="mx-auto max-w-5xl space-y-8">
            <div class="rounded-[2rem] bg-white p-8 shadow-sm ring-1 ring-slate-200 sm:p-10">
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-sky-600">Order Tracking</p>
                <h1 class="mt-3 text-4xl font-black tracking-tight text-slate-900 sm:text-5xl">Track your order</h1>
                <p class="mt-4 max-w-3xl text-base leading-7 text-slate-600">
                    Enter your order number and the email address or phone number used at checkout.
                </p>

                <form action="{{ route('front.track-order.lookup') }}" method="POST" class="mt-8 grid gap-4 md:grid-cols-2">
                    @csrf
                    <div>
                        <label for="order_number" class="mb-2 block text-sm font-semibold text-slate-800">Order Number</label>
                        <input id="order_number" name="order_number" type="text" value="{{ old('order_number') }}"
                            placeholder="ORD-XXXXXXXXXX"
                            class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-sky-500 focus:ring-2 focus:ring-sky-100">
                    </div>
                    <div>
                        <label for="contact" class="mb-2 block text-sm font-semibold text-slate-800">Email or Phone</label>
                        <input id="contact" name="contact" type="text" value="{{ old('contact') }}"
                            placeholder="you@example.com or 010..."
                            class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-sky-500 focus:ring-2 focus:ring-sky-100">
                    </div>
                    @error('order_number')
                        <div class="md:col-span-2 rounded-2xl border border-red-100 bg-red-50 px-4 py-3 text-sm text-red-600">
                            {{ $message }}
                        </div>
                    @enderror
                    <div class="md:col-span-2">
                        <button type="submit"
                            class="inline-flex items-center justify-center rounded-full bg-slate-900 px-6 py-3 text-sm font-semibold text-white transition hover:bg-slate-700">
                            Track Order
                        </button>
                    </div>
                </form>
            </div>

            @isset($order)
                @php
                    $statusColor = match ($order->status) {
                        'confirmed' => 'bg-blue-50 text-blue-600',
                        'shipped' => 'bg-indigo-50 text-indigo-600',
                        'delivered' => 'bg-green-50 text-green-600',
                        'cancelled' => 'bg-red-50 text-red-500',
                        default => 'bg-yellow-50 text-yellow-600',
                    };
                @endphp

                <div class="grid gap-6 xl:grid-cols-3">
                    <div class="space-y-6 xl:col-span-2">
                        <div class="rounded-[2rem] bg-white p-6 shadow-sm ring-1 ring-slate-200">
                            <div class="mb-5 flex flex-wrap items-start justify-between gap-4">
                                <div>
                                    <h2 class="text-2xl font-bold text-slate-900">Order #{{ $order->order_number }}</h2>
                                    <p class="mt-1 text-sm text-slate-500">{{ $order->created_at->format('d M, Y \\a\\t h:i A') }}</p>
                                </div>
                                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $statusColor }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="min-w-full text-sm">
                                    <thead>
                                        <tr class="border-b border-slate-100 text-left text-xs text-slate-400">
                                            <th class="pb-3 pr-4 font-medium">Product</th>
                                            <th class="pb-3 pr-4 font-medium">Qty</th>
                                            <th class="pb-3 pr-4 font-medium">Price</th>
                                            <th class="pb-3 text-right font-medium">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-50">
                                        @foreach ($order->items as $item)
                                            <tr>
                                                <td class="py-3 pr-4">
                                                    <p class="font-medium text-slate-800">
                                                        {{ $item->name_snapshot ?? ($item->product->name ?? 'Deleted Product') }}
                                                    </p>
                                                    @if ($item->size_snapshot || $item->color_snapshot)
                                                        <p class="text-xs text-slate-400">{{ $item->size_snapshot }} / {{ $item->color_snapshot }}</p>
                                                    @endif
                                                </td>
                                                <td class="py-3 pr-4 text-slate-600">{{ $item->qty }}</td>
                                                <td class="py-3 pr-4 text-slate-600">${{ number_format($item->unit_price_snapshot, 2) }}</td>
                                                <td class="py-3 text-right font-semibold text-slate-800">${{ number_format($item->line_total, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="rounded-[2rem] bg-white p-6 shadow-sm ring-1 ring-slate-200">
                            <h3 class="text-sm font-bold text-slate-700">Order Summary</h3>
                            <div class="mt-4 space-y-3 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-slate-400">Order #</span>
                                    <span class="font-mono text-xs text-slate-600">{{ $order->order_number }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-400">Payment</span>
                                    <span class="text-slate-600">{{ ucfirst($order->payment_method ?? '-') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-400">Payment Status</span>
                                    <span class="text-slate-600">{{ ucfirst($order->payment_status ?? '-') }}</span>
                                </div>
                                <div class="flex justify-between border-t border-slate-100 pt-3">
                                    <span class="text-slate-400">Total</span>
                                    <span class="text-lg font-bold text-sky-600">${{ number_format($order->total, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        @if ($order->address)
                            <div class="rounded-[2rem] bg-white p-6 shadow-sm ring-1 ring-slate-200">
                                <h3 class="text-sm font-bold text-slate-700">Shipping Address</h3>
                                <div class="mt-4 space-y-1 text-sm text-slate-600">
                                    <p class="font-medium text-slate-800">{{ $order->address->full_name }}</p>
                                    <p>{{ $order->address->address_line }}</p>
                                    @if ($order->address->city)
                                        <p>{{ $order->address->city }}</p>
                                    @endif
                                    <p>{{ $order->address->phone }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endisset
        </div>
    </section>
@endsection
