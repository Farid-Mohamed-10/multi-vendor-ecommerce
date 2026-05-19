@extends('admin-dashboard.master')
@section('title', 'Orders')
@section('orders active', 'active')

@section('content')
    <div class="p-4 sm:p-6 lg:p-8">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6 flex-wrap gap-3">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-800">Orders</h1>
                <p class="text-sm text-gray-400 mt-0.5">Manage all customer orders</p>
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

        {{-- Search & Filter --}}
        <form method="GET" action="{{ route('admin-dashboard.orders.index') }}"
            class="bg-white rounded-2xl p-4 mb-5 flex flex-wrap gap-3 items-center"
            style="box-shadow:0 2px 12px rgba(139,92,246,0.07)">
            <div class="relative flex-1 min-w-[200px]">
                <input type="text" name="search" placeholder="Search by order#, email, or customer…"
                    value="{{ request('search') }}"
                    class="w-full pl-9 pr-4 py-2 rounded-xl text-sm border border-purple-100 bg-purple-50/40 focus:outline-none focus:border-purple-400 text-gray-600 placeholder-gray-400">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
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
                Search
            </button>
            @if (request('search') || request('status'))
                <a href="{{ route('admin-dashboard.orders.index') }}"
                    class="px-4 py-2 rounded-xl text-sm font-semibold text-purple-600 hover:text-purple-700 border border-purple-200 hover:border-purple-300 transition-colors">
                    Clear
                </a>
            @endif
        </form>

        {{-- Table --}}
        <div class="bg-white rounded-2xl overflow-hidden" style="box-shadow:0 2px 12px rgba(139,92,246,0.07)">
            <div class="table-wrap">
                <table class="w-full text-sm min-w-[700px]">
                    <thead>
                        <tr class="text-left text-xs text-gray-400 border-b border-gray-100">
                            <th class="px-6 py-4 font-medium">#</th>
                            <th class="px-6 py-4 font-medium">Order Number</th>
                            <th class="px-6 py-4 font-medium">Customer</th>
                            <th class="px-6 py-4 font-medium hidden sm:table-cell">Payment</th>
                            <th class="px-6 py-4 font-medium">Total</th>
                            <th class="px-6 py-4 font-medium">Status</th>
                            <th class="px-6 py-4 font-medium hidden md:table-cell">Date</th>
                            <th class="px-6 py-4 font-medium text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse ($orders as $order)
                            <tr class="hover:bg-purple-50/20 transition-colors">

                                <td class="px-6 py-4 text-gray-400 text-xs font-mono">
                                    {{ ($orders->currentPage() - 1) * $orders->perPage() + $loop->iteration }}</td>

                                <td class="px-6 py-4 font-mono text-xs text-gray-600 whitespace-nowrap">
                                    {{ $order->order_number }}
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0"
                                            style="background:linear-gradient(135deg,#7C3AED,#EC4899)">
                                            {{ strtoupper(substr($order->user->name ?? 'G', 0, 2)) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-700 whitespace-nowrap">
                                                {{ $order->user->name ?? 'Guest' }}</p>
                                            <p class="text-xs text-gray-400">{{ $order->email }}</p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 hidden sm:table-cell">
                                    <span class="text-xs text-gray-500">{{ ucfirst($order->payment_method ?? '—') }}</span>
                                    <br>
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

                                <td class="px-6 py-4 text-gray-400 text-xs hidden md:table-cell whitespace-nowrap">
                                    {{ $order->created_at->format('d M, Y') }}
                                </td>

                                {{-- Actions --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        {{-- View --}}
                                        <a href="{{ route('admin-dashboard.orders.show', $order) }}"
                                            class="p-1.5 rounded-lg text-gray-400 hover:text-purple-600 hover:bg-purple-50 transition-colors"
                                            title="View">
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
                                <td colspan="8" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center bg-purple-50">
                                            <svg class="w-6 h-6 text-purple-300" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                        </div>
                                        <p class="text-gray-400 text-sm font-medium">No orders found</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($orders->hasPages())
                <div class="px-6 py-4 border-t border-gray-50">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>

    </div>
@endsection
