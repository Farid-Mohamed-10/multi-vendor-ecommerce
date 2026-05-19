@extends('admin-dashboard.master')
@section('title', 'Overview')

@section('overview active', 'active')

@section('content')
    <main class="flex-1 min-w-0 p-4 sm:p-6 lg:p-8 overflow-hidden">

        <h1 class="text-xl sm:text-2xl font-bold text-gray-800 mb-5 fade-up">Dashboard Overview</h1>

        <!-- STAT CARDS: 1 → 2 → 4 cols -->
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">

            <div class="stat-card bg-white rounded-2xl p-4 sm:p-5 fade-up d1">
                <div class="flex items-start justify-between mb-4">
                    <div class="icon-box icon-users">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    {{-- <span class="badge-up">+15.3%</span> --}}
                </div>
                <p class="text-xs text-gray-400 font-medium mb-1">Total Users</p>
                <p class="text-2xl font-bold text-gray-800">{{ $usersCount }}</p>
            </div>

            <div class="stat-card bg-white rounded-2xl p-4 sm:p-5 fade-up d2">
                <div class="flex items-start justify-between mb-4">
                    <div class="icon-box icon-products">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    {{-- <span class="badge-up">+8.7%</span> --}}
                </div>
                <p class="text-xs text-gray-400 font-medium mb-1">Total Products</p>
                <p class="text-2xl font-bold text-gray-800">{{ $productsCount }}</p>
            </div>

            <div class="stat-card bg-white rounded-2xl p-4 sm:p-5 fade-up d3">
                <div class="flex items-start justify-between mb-4">
                    <div class="icon-box icon-orders">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    {{-- <span class="badge-up">+12.1%</span> --}}
                </div>
                <p class="text-xs text-gray-400 font-medium mb-1">Total Orders</p>
                <p class="text-2xl font-bold text-gray-800">{{ $ordersCount }}</p>
            </div>

            <div class="stat-card bg-white rounded-2xl p-4 sm:p-5 fade-up d4">
                <div class="flex items-start justify-between mb-4">
                    <div class="icon-box icon-revenue">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    {{-- <span class="badge-up">+18.4%</span> --}}
                </div>
                <p class="text-xs text-gray-400 font-medium mb-1">Revenue</p>
                <p class="text-2xl font-bold text-gray-800">${{ $totalRevenue }}</p>
            </div>
        </div>

        <!-- CHARTS: 1 col → 2 cols on large screens -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-6">

            <!-- Sales Overview -->
            <div class="bg-white rounded-2xl p-4 sm:p-6 fade-up d5">
                <div class="flex items-center justify-between flex-wrap gap-2 mb-4">
                    <h2 class="text-sm sm:text-base font-bold text-gray-800">Sales Overview</h2>
                    <select id="salesRangeFilter"
                        class="text-xs text-gray-500 border border-gray-100 rounded-lg px-2 py-1.5 bg-gray-50 focus:outline-none focus:border-purple-300"
                        onchange="const range = this.value; window.location.href = `{{ route('admin-dashboard.index') }}?range=${range}`">
                        <option value="30days" {{ request('range') == '30days' ? 'selected' : '' }}>Last 30 days</option>
                        <option value="7months" {{ request('range') == '7months' ? 'selected' : '' }}>Last 7 months</option>
                        <option value="year" {{ request('range') == 'year' ? 'selected' : '' }}>This year</option>
                    </select>
                </div>
                <div class="chart-container">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>

            <!-- Category Distribution -->
            <div class="bg-white rounded-2xl p-4 sm:p-6 fade-up d6">
                <h2 class="text-sm sm:text-base font-bold text-gray-800 mb-4">Category Distribution</h2>
                <div class="flex flex-col sm:flex-row items-center gap-5">
                    <div class="flex-shrink-0" style="width:160px;height:160px">
                        <canvas id="categoryChart"></canvas>
                    </div>
                    @php
                        $colors = [
                            '#7C3AED', // purple
                            '#EC4899', // pink
                            '#F59E0B', // orange
                            '#10B981', // green
                            '#3B82F6', // blue
                            '#EF4444', // red
                            '#14B8A6', // teal
                        ];
                    @endphp

                    <div class="flex flex-col gap-2.5 flex-1 w-full">
                        @foreach ($categoryLabels as $i => $label)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="category-dot" style="background: {{ $categoryColors[$i] }}"></span>
                                    <span class="text-xs text-gray-600">{{ $label }}</span>
                                </div>

                                <span class="text-xs font-bold text-gray-800">
                                    %{{ $categoryData[$i] }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- RECENT ORDERS TABLE -->
        <div class="bg-white rounded-2xl p-4 sm:p-6 fade-up">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm sm:text-base font-bold text-gray-800">Recent Orders</h2>
                <a href="{{ route('admin-dashboard.orders.index') }}"
                    class="text-xs text-purple-600 font-semibold hover:text-purple-800 transition-colors">View
                    All →</a>
            </div>
            <div class="table-wrap -mx-1 px-1">
                <table class="w-full text-sm min-w-[480px]">
                    <thead>
                        <tr class="text-left text-xs text-gray-400 border-b border-gray-100">
                            <th class="pb-3 font-medium pr-4 whitespace-nowrap">Order ID</th>
                            <th class="pb-3 font-medium pr-4 whitespace-nowrap">Customer</th>
                            <th class="pb-3 font-medium pr-4 whitespace-nowrap hidden sm:table-cell">Category</th>
                            <th class="pb-3 font-medium pr-4 whitespace-nowrap">Amount</th>
                            <th class="pb-3 font-medium whitespace-nowrap">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @if (count($orders))
                            @foreach ($orders as $order)
                                <tr class="hover:bg-purple-50/30 transition-colors">
                                    <td class="py-3 pr-4 text-gray-500 font-mono text-xs whitespace-nowrap">
                                        {{ $order->order_number }}</td>
                                    <td class="py-3 pr-4 font-medium text-gray-700 whitespace-nowrap">
                                        {{ $order->user->name }}</td>
                                    <td class="py-3 pr-4 text-gray-500 hidden sm:table-cell">
                                        {{ $order->items->first()->product->category->name ?? 'N/A' }}
                                    </td>
                                    <td class="py-3 pr-4 font-semibold text-gray-800 whitespace-nowrap">{{ $order->total }}
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
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

    </main>
@endsection

@push('scripts')
    <script>
        // ── Sales Chart ────────────────────────────────────────
        const salesLabels = @json($salesLabels);
        const salesData = @json($salesData);

        new Chart(document.getElementById('salesChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: salesLabels,
                datasets: [{
                    data: salesData,
                    borderColor: '#8B5CF6',
                    backgroundColor: 'rgba(139,92,246,0.08)',
                    borderWidth: 2.5,
                    pointBackgroundColor: '#8B5CF6',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 10
                            },
                            color: '#9CA3AF'
                        }
                    },
                    y: {
                        grid: {
                            color: '#F3F4F6'
                        },
                        ticks: {
                            font: {
                                size: 10
                            },
                            color: '#9CA3AF',
                            callback: v => v >= 1000 ? (v / 1000) + 'k' : v
                        },
                        border: {
                            display: false
                        }
                    }
                }
            }
        });

        // ── Category Chart (Dynamic) ─────────────────────────
        const categoryLabels = @json($categoryLabels);
        const categoryData = @json($categoryData);
        const categoryColors = @json($categoryColors);

        new Chart(document.getElementById('categoryChart').getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: categoryLabels,
                datasets: [{
                    data: categoryData,
                    backgroundColor: categoryColors,
                    borderWidth: 0,
                    hoverOffset: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: (ctx) => ` ${ctx.label}: ${ctx.parsed}%`
                        }
                    }
                }
            }
        });
    </script>
@endpush
