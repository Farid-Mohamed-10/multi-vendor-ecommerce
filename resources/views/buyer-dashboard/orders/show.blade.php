@extends('buyer-dashboard.master')
@section('title', 'Order #' . $order->order_number)
@section('orders active', 'active')

@section('content')
    <div class="p-4 sm:p-6 lg:p-8">

        {{-- Header --}}
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('buyer-dashboard.orders') }}"
                class="p-2 rounded-xl text-gray-400 hover:text-purple-600 hover:bg-purple-50 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-800">Order #{{ $order->order_number }}</h1>
                <p class="text-sm text-gray-400 mt-0.5">{{ $order->created_at->format('d M, Y \\a\\t h:i A') }}</p>
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

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

            {{-- Items --}}
            <div class="xl:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl p-6" style="box-shadow:0 2px 12px rgba(139,92,246,0.07)">
                    <h2 class="text-sm font-bold text-gray-700 mb-4">Order Items</h2>
                    <div class="table-wrap">
                        <table class="w-full text-sm min-w-[400px]">
                            <thead>
                                <tr class="text-left text-xs text-gray-400 border-b border-gray-100">
                                    <th class="pb-3 font-medium pr-4">Product</th>
                                    <th class="pb-3 font-medium pr-4">Qty</th>
                                    <th class="pb-3 font-medium pr-4">Price</th>
                                    <th class="pb-3 font-medium text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach ($order->items as $item)
                                    <tr>
                                        <td class="py-3 pr-4">
                                            <p class="font-medium text-gray-700">
                                                {{ $item->name_snapshot ?? ($item->product->name ?? 'Deleted Product') }}
                                            </p>
                                            @if ($item->size_snapshot || $item->color_snapshot)
                                                <p class="text-xs text-gray-400">{{ $item->size_snapshot }} /
                                                    {{ $item->color_snapshot }}</p>
                                            @endif
                                        </td>
                                        <td class="py-3 pr-4 text-gray-600">{{ $item->qty }}</td>
                                        <td class="py-3 pr-4 text-gray-600">
                                            ${{ number_format($item->unit_price_snapshot, 2) }}</td>
                                        <td class="py-3 text-right font-semibold text-gray-800">
                                            ${{ number_format($item->line_total, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="border-t border-gray-100">
                                    <td colspan="3" class="py-3 pr-4 text-right text-xs text-gray-400 font-medium">
                                        Subtotal</td>
                                    <td class="py-3 text-right text-gray-600">${{ number_format($order->subtotal, 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="py-2 pr-4 text-right text-sm font-bold text-gray-700">Total
                                    </td>
                                    <td class="py-2 text-right text-lg font-bold text-purple-600">
                                        ${{ number_format($order->total, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                {{-- Shipping Address --}}
                @if ($order->address)
                    <div class="bg-white rounded-2xl p-6" style="box-shadow:0 2px 12px rgba(139,92,246,0.07)">
                        <h2 class="text-sm font-bold text-gray-700 mb-4">Shipping Address</h2>
                        <div class="text-sm text-gray-600 space-y-1">
                            <p class="font-medium text-gray-800">{{ $order->address->full_name ?? '' }}</p>
                            <p>{{ $order->address->address_line ?? '' }}</p>
                            <p>{{ $order->address->city ?? '' }}</p>
                            <p>{{ $order->address->phone ?? '' }}</p>
                            @if ($order->address->notes)
                                <p class="text-xs text-gray-400 mt-2">Notes: {{ $order->address->notes }}</p>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            {{-- Sidebar Info --}}
            <div class="space-y-6">
                <div class="bg-white rounded-2xl p-6" style="box-shadow:0 2px 12px rgba(139,92,246,0.07)">
                    <h2 class="text-sm font-bold text-gray-700 mb-4">Order Summary</h2>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-400">Order #</span>
                            <span class="font-mono text-xs text-gray-600">{{ $order->order_number }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Payment</span>
                            <span class="text-gray-600">{{ ucfirst($order->payment_method ?? '—') }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400">Status</span>
                            @php
                                $statusColor = match ($order->status) {
                                    'confirmed' => 'bg-blue-50 text-blue-600',
                                    'shipped' => 'bg-indigo-50 text-indigo-600',
                                    'delivered' => 'bg-green-50 text-green-600',
                                    'cancelled' => 'bg-red-50 text-red-500',
                                    default => 'bg-yellow-50 text-yellow-600',
                                };
                            @endphp
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $statusColor }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        <div class="flex justify-between pt-3 border-t border-gray-100">
                            <span class="text-gray-400">Total</span>
                            <span class="text-lg font-bold text-purple-600">${{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>
                </div>

                {{-- Cancel Order --}}
                @if ($order->status === 'pending')
                    <div class="bg-white rounded-2xl p-6" style="box-shadow:0 2px 12px rgba(139,92,246,0.07)">
                        <h2 class="text-sm font-bold text-gray-700 mb-3">Cancel Order</h2>
                        <p class="text-xs text-gray-400 mb-4">You can cancel this order while it's still pending.</p>
                        <form action="{{ route('buyer-dashboard.orders.cancel', $order) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to cancel this order?')">
                            @csrf @method('PATCH')
                            <button type="submit"
                                class="w-full px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-red-500 hover:bg-red-600 transition-colors">
                                Cancel Order
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
