@extends('buyer-dashboard.master')
@section('title', 'Dashboard')
@section('overview active', 'active')

@section('content')
    <div class="p-4 sm:p-6 lg:p-8">

        <h1 class="text-xl sm:text-2xl font-bold text-gray-800 mb-5 fade-up">Dashboard Overview</h1>

        {{-- Stat Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">

            <div class="stat-card bg-white rounded-2xl p-4 sm:p-5 fade-up d1">
                <div class="flex items-start justify-between mb-4">
                    <div class="icon-box" style="background:linear-gradient(135deg,#7C3AED,#A78BFA)">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-400 font-medium mb-1">Total Orders</p>
                <p class="text-2xl font-bold text-gray-800">{{ $totalOrders }}</p>
            </div>

            <div class="stat-card bg-white rounded-2xl p-4 sm:p-5 fade-up d2">
                <div class="flex items-start justify-between mb-4">
                    <div class="icon-box" style="background:linear-gradient(135deg,#10B981,#34D399)">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-400 font-medium mb-1">Total Spent</p>
                <p class="text-2xl font-bold text-gray-800">${{ number_format($totalSpent, 2) }}</p>
            </div>

            <div class="stat-card bg-white rounded-2xl p-4 sm:p-5 fade-up d3">
                <div class="flex items-start justify-between mb-4">
                    <div class="icon-box" style="background:linear-gradient(135deg,#F59E0B,#FBBF24)">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-400 font-medium mb-1">Pending</p>
                <p class="text-2xl font-bold text-gray-800">{{ $pendingOrders }}</p>
            </div>

            <div class="stat-card bg-white rounded-2xl p-4 sm:p-5 fade-up d4">
                <div class="flex items-start justify-between mb-4">
                    <div class="icon-box" style="background:linear-gradient(135deg,#3B82F6,#60A5FA)">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-400 font-medium mb-1">Delivered</p>
                <p class="text-2xl font-bold text-gray-800">{{ $deliveredOrders }}</p>
            </div>

        </div>

        {{-- Recent Orders --}}
        <div class="bg-white rounded-2xl p-4 sm:p-6 fade-up" style="box-shadow:0 2px 12px rgba(139,92,246,0.07)">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm sm:text-base font-bold text-gray-800">Recent Orders</h2>
                <a href="{{ route('buyer-dashboard.orders') }}"
                    class="text-xs text-purple-600 font-semibold hover:text-purple-800 transition-colors">View All →</a>
            </div>
            <div class="table-wrap -mx-1 px-1">
                <table class="w-full text-sm min-w-[480px]">
                    <thead>
                        <tr class="text-left text-xs text-gray-400 border-b border-gray-100">
                            <th class="pb-3 font-medium pr-4 whitespace-nowrap">Order #</th>
                            <th class="pb-3 font-medium pr-4 whitespace-nowrap">Items</th>
                            <th class="pb-3 font-medium pr-4 whitespace-nowrap">Total</th>
                            <th class="pb-3 font-medium pr-4 whitespace-nowrap hidden sm:table-cell">Date</th>
                            <th class="pb-3 font-medium whitespace-nowrap">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse ($recentOrders as $order)
                            <tr class="hover:bg-purple-50/30 transition-colors">
                                <td class="py-3 pr-4 font-mono text-xs text-gray-500 whitespace-nowrap">
                                    <a href="{{ route('buyer-dashboard.orders.show', $order) }}"
                                        class="hover:text-purple-600">{{ $order->order_number }}</a>
                                </td>
                                <td class="py-3 pr-4 text-gray-600 text-xs">
                                    {{ $order->items->count() }} item(s)
                                </td>
                                <td class="py-3 pr-4 font-semibold text-gray-800 whitespace-nowrap">
                                    ${{ number_format($order->total, 2) }}
                                </td>
                                <td class="py-3 pr-4 text-gray-400 text-xs hidden sm:table-cell whitespace-nowrap">
                                    {{ $order->created_at->format('d M, Y') }}
                                </td>
                                <td class="py-3">
                                    @php
                                        $statusColor = match ($order->status) {
                                            'confirmed' => 'bg-blue-50 text-blue-600',
                                            'shipped' => 'bg-indigo-50 text-indigo-600',
                                            'delivered' => 'bg-green-50 text-green-600',
                                            'cancelled' => 'bg-red-50 text-red-500',
                                            default => 'bg-yellow-50 text-yellow-600',
                                        };
                                    @endphp
                                    <span
                                        class="{{ $statusColor }} text-xs px-2 py-1 rounded-full font-semibold whitespace-nowrap">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-10 text-center text-gray-400 text-sm">
                                    No orders yet. <a href="{{ route('front.products') }}"
                                        class="text-purple-600 font-semibold hover:underline">Start shopping →</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
