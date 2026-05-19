@extends('admin-dashboard.master')
@section('title', 'Order #' . $order->order_number)
@section('orders active', 'active')

@section('content')
    <div class="p-4 sm:p-6 lg:p-8">

        {{-- Header --}}
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('admin-dashboard.orders.index') }}"
                class="p-2 rounded-xl text-gray-400 hover:text-purple-600 hover:bg-purple-50 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-800">Order #{{ $order->order_number }}</h1>
                <p class="text-sm text-gray-400 mt-0.5">Placed on {{ $order->created_at->format('d M, Y \\a\\t h:i A') }}
                </p>
            </div>
        </div>

        {{-- Flash Message --}}
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

            {{-- Left: Order Items --}}
            <div class="xl:col-span-2 space-y-6">

                {{-- Items Table --}}
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
                                                {{ $item->product->name ?? 'Deleted Product' }}</p>
                                            @if ($item->stock)
                                                <p class="text-xs text-gray-400">
                                                    {{ $item->stock->size ?? '' }} / {{ $item->stock->color ?? '' }}
                                                </p>
                                            @endif
                                        </td>
                                        <td class="py-3 pr-4 text-gray-600">{{ $item->qty }}</td>
                                        <td class="py-3 pr-4 text-gray-600">${{ number_format($item->price, 2) }}</td>
                                        <td class="py-3 text-right font-semibold text-gray-800">
                                            ${{ number_format($item->qty * $item->price, 2) }}
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
                            <p class="font-medium text-gray-800">{{ $order->address->name ?? '' }}</p>
                            <p>{{ $order->address->address ?? '' }}</p>
                            <p>{{ $order->address->city ?? '' }}{{ $order->address->state ? ', ' . $order->address->state : '' }}
                                {{ $order->address->zip ?? '' }}</p>
                            <p>{{ $order->address->phone ?? '' }}</p>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Right: Summary & Actions --}}
            <div class="space-y-6">

                {{-- Order Summary --}}
                <div class="bg-white rounded-2xl p-6" style="box-shadow:0 2px 12px rgba(139,92,246,0.07)">
                    <h2 class="text-sm font-bold text-gray-700 mb-4">Order Summary</h2>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-400">Customer</span>
                            <span class="font-medium text-gray-700">{{ $order->user->name ?? 'Guest' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Email</span>
                            <span class="text-gray-600">{{ $order->email }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Payment</span>
                            <span class="text-gray-600">{{ ucfirst($order->payment_method ?? '—') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Payment Status</span>
                            @php
                                $pColor = match ($order->payment_status ?? 'pending') {
                                    'paid' => 'bg-green-50 text-green-600',
                                    'failed' => 'bg-red-50 text-red-500',
                                    default => 'bg-yellow-50 text-yellow-600',
                                };
                            @endphp
                            <span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $pColor }}">
                                {{ ucfirst($order->payment_status ?? 'pending') }}
                            </span>
                        </div>
                        <div class="flex justify-between pt-3 border-t border-gray-100">
                            <span class="text-gray-400">Total</span>
                            <span class="text-lg font-bold text-purple-600">${{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>
                </div>

                {{-- Update Status --}}
                <div class="bg-white rounded-2xl p-6" style="box-shadow:0 2px 12px rgba(139,92,246,0.07)">
                    <h2 class="text-sm font-bold text-gray-700 mb-4">Update Status</h2>
                    <form action="{{ route('admin-dashboard.orders.updateStatus', $order) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <select name="status"
                            class="w-full px-4 py-2.5 rounded-xl text-sm border border-purple-100 bg-purple-50/30 focus:outline-none focus:border-purple-400 focus:bg-white mb-3">
                            @foreach (['pending', 'confirmed', 'shipped', 'delivered', 'cancelled'] as $s)
                                <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>
                                    {{ ucfirst($s) }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit"
                            class="w-full px-4 py-2.5 rounded-xl text-sm font-semibold text-white transition-opacity hover:opacity-90"
                            style="background:linear-gradient(135deg,#7C3AED,#EC4899)">
                            Update Status
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
