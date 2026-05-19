@extends('seller-dashboard.master')
@section('title', 'Orders')
@section('orders active', 'active')

@section('content')
    <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8 fade-up">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-800 tracking-tight">Order Management</h1>
                <p class="text-slate-500 mt-1">Track and manage purchases of your products.</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="bg-indigo-50 text-indigo-600 text-sm font-bold px-4 py-2 rounded-full border border-indigo-100">
                    Total: {{ $orderItems->total() }} Orders
                </span>
            </div>
        </div>

        {{-- Flash Message --}}
        @if (session('success'))
            <div
                class="flex items-center gap-3 bg-emerald-50 border border-emerald-100 text-emerald-700 text-sm px-4 py-3 rounded-xl mb-6 fade-up">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div
                class="flex items-center gap-3 bg-rose-50 border border-rose-100 text-rose-700 text-sm px-4 py-3 rounded-xl mb-6 fade-up">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ session('error') }}
            </div>
        @endif

        <!-- Main Content Box -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden fade-up d1">

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="bg-slate-50/50 border-b border-slate-100 text-sm font-semibold text-slate-500 uppercase tracking-wider">
                            <th class="p-4 whitespace-nowrap">Product</th>
                            <th class="p-4 whitespace-nowrap">Customer</th>
                            <th class="p-4 whitespace-nowrap">Qty / Variant</th>
                            <th class="p-4 whitespace-nowrap">Total</th>
                            <th class="p-4 whitespace-nowrap">Date</th>
                            <th class="p-4 whitespace-nowrap text-right">Status Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-slate-50">
                        @forelse ($orderItems as $item)
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <!-- Product Column -->
                                <td class="p-4">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-12 h-12 rounded-xl bg-slate-100 overflow-hidden border border-slate-200 flex-shrink-0">
                                            @if ($item->product->images && count($item->product->images) > 0)
                                                <img src="{{ asset('storage/' . $item->product->images[0]) }}"
                                                    class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-slate-400">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                        </path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-800 line-clamp-1 max-w-[200px]"
                                                title="{{ $item->name_snapshot }}">
                                                {{ $item->name_snapshot }}
                                            </p>
                                            <p class="text-xs text-slate-500 mt-1">Order
                                                #{{ str_pad($item->order->id, 5, '0', STR_PAD_LEFT) }}</p>
                                        </div>
                                    </div>
                                </td>

                                <!-- Customer Column -->
                                <td class="p-4 text-slate-700">
                                    <p class="font-medium">{{ $item->order->user->name ?? 'Guest User' }}</p>
                                </td>

                                <!-- Variant & Qty -->
                                <td class="p-4">
                                    <p class="font-medium text-slate-700">{{ $item->qty }}x</p>
                                    <p class="text-xs text-slate-500 flex gap-2 mt-1">
                                        @if ($item->size_snapshot)
                                            <span
                                                class="bg-indigo-50 text-indigo-600 px-1.5 rounded">{{ $item->size_snapshot }}</span>
                                        @endif
                                        @if ($item->color_snapshot)
                                            <span class="flex items-center gap-1 bg-slate-100 px-1.5 rounded">
                                                <span class="w-2 h-2 rounded-full border border-black/10"
                                                    style="background-color: {{ $item->color_snapshot }}"></span>
                                                {{ $item->color_snapshot }}
                                            </span>
                                        @endif
                                    </p>
                                </td>

                                <!-- Total -->
                                <td class="p-4 font-bold text-emerald-600">
                                    ${{ number_format($item->line_total, 2) }}
                                </td>

                                <!-- Date -->
                                <td class="p-4 text-slate-500 whitespace-nowrap">
                                    {{ $item->created_at->format('M d, Y') }}
                                </td>

                                <!-- Status & Action -->
                                <td class="p-4 text-right">
                                    <form action="{{ route('seller-dashboard.orders.updateStatus', $item) }}"
                                        method="POST" class="inline-block relative" x-data="{ expanded: false }">
                                        @csrf
                                        @method('PATCH')
                                        <div class="relative inline-flex items-center">
                                            <select name="status" onchange="this.form.submit()"
                                                class="appearance-none pl-3 pr-8 py-1.5 rounded-full text-xs font-bold font-sans cursor-pointer outline-none border transition-colors shadow-sm
                                                @if ($item->order->status === 'delivered') bg-emerald-50 text-emerald-700 border-emerald-200 hover:bg-emerald-100
                                                @elseif($item->order->status === 'canceled') bg-rose-50 text-rose-700 border-rose-200 hover:bg-rose-100
                                                @elseif($item->order->status === 'shipped') bg-blue-50 text-blue-700 border-blue-200 hover:bg-blue-100
                                                @else bg-amber-50 text-amber-700 border-amber-200 hover:bg-amber-100 @endif
                                            ">
                                                <option value="pending"
                                                    {{ $item->order->status === 'pending' ? 'selected' : '' }}>Pending
                                                </option>
                                                <option value="processing"
                                                    {{ $item->order->status === 'processing' ? 'selected' : '' }}>
                                                    Processing</option>
                                                <option value="shipped"
                                                    {{ $item->order->status === 'shipped' ? 'selected' : '' }}>Shipped
                                                </option>
                                                <option value="delivered"
                                                    {{ $item->order->status === 'delivered' ? 'selected' : '' }}>Delivered
                                                </option>
                                                <option value="canceled"
                                                    {{ $item->order->status === 'canceled' ? 'selected' : '' }}>Canceled
                                                </option>
                                            </select>
                                            <svg class="w-3 h-3 absolute right-2.5 pointer-events-none opacity-50 
                                                @if ($item->order->status === 'delivered') text-emerald-700
                                                @elseif($item->order->status === 'canceled') text-rose-700
                                                @elseif($item->order->status === 'shipped') text-blue-700
                                                @else text-amber-700 @endif"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                    d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-12 text-center">
                                    <div
                                        class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-50 mb-4">
                                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                    </div>
                                    <p class="text-slate-500 font-medium">You don't have any orders yet.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($orderItems->hasPages())
                <div class="px-4 py-3 border-t border-slate-100 bg-slate-50/50">
                    {{ $orderItems->links() }}
                </div>
            @endif

        </div>

    </div>
@endsection
