@extends('buyer-dashboard.master')
@section('title', 'My Orders')
@section('orders active', 'active')

@section('content')
    <div class="p-4 sm:p-6 lg:p-8">

        <div class="flex items-center justify-between mb-6 flex-wrap gap-3">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-800">My Orders</h1>
                <p class="text-sm text-gray-400 mt-0.5">Track all your purchases</p>
            </div>
        </div>

        {{-- Status Filter --}}
        <form method="GET" action="{{ route('buyer-dashboard.orders') }}"
            class="bg-white rounded-2xl p-4 mb-5 flex flex-wrap gap-3 items-center"
            style="box-shadow:0 2px 12px rgba(139,92,246,0.07)">
            <select name="status"
                class="text-sm border border-purple-100 bg-purple-50/40 rounded-xl px-3 py-2 text-gray-500 focus:outline-none focus:border-purple-400">
                <option value="">All Statuses</option>
                @foreach (['pending', 'confirmed', 'shipped', 'delivered', 'cancelled'] as $s)
                    <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>
                        {{ ucfirst($s) }}
                    </option>
                @endforeach
            </select>
            <button type="submit"
                class="px-4 py-2 rounded-xl text-sm font-semibold text-white bg-purple-500 hover:bg-purple-600 transition-colors">
                Filter
            </button>
            @if (request('status'))
                <a href="{{ route('buyer-dashboard.orders') }}"
                    class="px-4 py-2 rounded-xl text-sm font-semibold text-purple-600 border border-purple-200 hover:border-purple-300 transition-colors">
                    Clear
                </a>
            @endif
        </form>

        {{-- Orders Table --}}
        <div class="bg-white rounded-2xl overflow-hidden" style="box-shadow:0 2px 12px rgba(139,92,246,0.07)">
            <div class="table-wrap">
                <table class="w-full text-sm min-w-[550px]">
                    <thead>
                        <tr class="text-left text-xs text-gray-400 border-b border-gray-100">
                            <th class="px-6 py-4 font-medium">Order #</th>
                            <th class="px-6 py-4 font-medium">Items</th>
                            <th class="px-6 py-4 font-medium">Total</th>
                            <th class="px-6 py-4 font-medium">Status</th>
                            <th class="px-6 py-4 font-medium hidden sm:table-cell">Date</th>
                            <th class="px-6 py-4 font-medium text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse ($orders as $order)
                            <tr class="hover:bg-purple-50/20 transition-colors">
                                <td class="px-6 py-4 font-mono text-xs text-gray-600 whitespace-nowrap">
                                    {{ $order->order_number }}
                                </td>
                                <td class="px-6 py-4 text-gray-500 text-xs">
                                    {{ $order->items->count() }} item(s)
                                </td>
                                <td class="px-6 py-4 font-semibold text-gray-800 whitespace-nowrap">
                                    ${{ number_format($order->total, 2) }}
                                </td>
                                <td class="px-6 py-4">
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
                                </td>
                                <td class="px-6 py-4 text-gray-400 text-xs hidden sm:table-cell whitespace-nowrap">
                                    {{ $order->created_at->format('d M, Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('buyer-dashboard.orders.show', $order) }}"
                                            class="p-1.5 rounded-lg text-gray-400 hover:text-purple-600 hover:bg-purple-50 transition-colors"
                                            title="View Details">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center bg-purple-50">
                                            <svg class="w-6 h-6 text-purple-300" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                        </div>
                                        <p class="text-gray-400 text-sm font-medium">No orders found</p>
                                        <a href="{{ route('front.products') }}"
                                            class="text-xs text-purple-600 font-semibold hover:underline">
                                            Start shopping →
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($orders->hasPages())
                <div class="px-6 py-4 border-t border-gray-50">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>

    </div>
@endsection
