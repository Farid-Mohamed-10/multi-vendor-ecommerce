@extends('seller-dashboard.master')
@section('title', 'Dashboard')
@section('overview active', 'active')

@section('content')
    <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8 fade-up">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-800 tracking-tight">Dashboard Overview</h1>
                <p class="text-slate-500 mt-1">Here's what's happening with your store today.</p>
            </div>
            <div class="flex items-center gap-3">
                <span
                    class="text-sm font-medium text-slate-500 bg-white px-3 py-1.5 rounded-full shadow-sm border border-slate-100">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block mr-1.5"></span> Live Status
                </span>
            </div>
        </div>

        <!-- ── STATS CARDS ──────────────────────────────────────── -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            <!-- Total Revenue -->
            <div
                class="stat-card bg-white rounded-2xl p-5 border border-slate-100 shadow-sm relative overflow-hidden fade-up d1 group">
                <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <svg class="w-24 h-24 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="flex items-start justify-between relative z-10">
                    <div>
                        <p class="text-sm font-medium text-slate-500 mb-1">Total Revenue</p>
                        <h3 class="text-3xl font-black text-slate-800">${{ number_format($totalRevenue, 2) }}</h3>
                    </div>
                    <div
                        class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-white shadow-lg shadow-emerald-200">
                        <svg class="w-6 h-6" fill="fill" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Orders -->
            <div
                class="stat-card bg-white rounded-2xl p-5 border border-slate-100 shadow-sm relative overflow-hidden fade-up d2 group">
                <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <svg class="w-24 h-24 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <div class="flex items-start justify-between relative z-10">
                    <div>
                        <p class="text-sm font-medium text-slate-500 mb-1">Total Orders</p>
                        <h3 class="text-3xl font-black text-slate-800">{{ number_format($totalOrders) }}</h3>
                    </div>
                    <div
                        class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white shadow-lg shadow-indigo-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Products -->
            <div
                class="stat-card bg-white rounded-2xl p-5 border border-slate-100 shadow-sm relative overflow-hidden fade-up d3 group">
                <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <svg class="w-24 h-24 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <div class="flex items-start justify-between relative z-10">
                    <div>
                        <p class="text-sm font-medium text-slate-500 mb-1">Active Products</p>
                        <h3 class="text-3xl font-black text-slate-800">{{ number_format($totalProducts) }}</h3>
                    </div>
                    <div
                        class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center text-white shadow-lg shadow-amber-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Pending Orders -->
            <div
                class="stat-card bg-white rounded-2xl p-5 border border-slate-100 shadow-sm relative overflow-hidden fade-up d4 group">
                <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <svg class="w-24 h-24 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="flex items-start justify-between relative z-10">
                    <div>
                        <p class="text-sm font-medium text-slate-500 mb-1">Pending Action</p>
                        <h3 class="text-3xl font-black text-slate-800">{{ number_format($pendingOrders) }}</h3>
                    </div>
                    <div
                        class="w-12 h-12 rounded-xl bg-gradient-to-br from-rose-400 to-pink-600 flex items-center justify-center text-white shadow-lg shadow-rose-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- ── CHART & RECENT ORDERS ───────────────────────────── -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">

            <!-- Revenue Chart -->
            <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm p-6 fade-up d5">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-bold text-slate-800">Revenue Overview (Last 7 Days)</h2>
                </div>
                <div class="relative h-[300px] w-full">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            <!-- Recent Orders List -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 fade-up d6 flex flex-col">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-bold text-slate-800">Recent Sales</h2>
                    <a href="{{ route('seller-dashboard.orders.index') }}"
                        class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition-colors">View All</a>
                </div>

                <div class="flex-1 overflow-y-auto pr-2 -mr-2 space-y-4">
                    @forelse($recentOrders as $item)
                        <div
                            class="flex items-center gap-4 p-3 rounded-xl border border-slate-50 hover:border-slate-100 hover:bg-slate-50 transition-all">
                            <div class="w-12 h-12 rounded-lg overflow-hidden bg-slate-100 flex-shrink-0">
                                @if ($item->product->images && count($item->product->images) > 0)
                                    <img src="{{ asset('storage/' . $item->product->images[0]) }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-400">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-bold text-slate-800 truncate">{{ $item->name_snapshot }}</p>
                                <p class="text-xs text-slate-500 mt-0.5">{{ $item->order->user->name ?? 'Guest' }} •
                                    {{ $item->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-black text-emerald-600">${{ number_format($item->line_total, 2) }}
                                </p>
                                <span
                                    class="inline-block mt-1 text-[10px] font-bold px-2 py-0.5 rounded-full 
                                    @if ($item->order->status === 'delivered') bg-emerald-100 text-emerald-700
                                    @elseif($item->order->status === 'canceled') bg-rose-100 text-rose-700
                                    @elseif($item->order->status === 'shipped') bg-blue-100 text-blue-700
                                    @else bg-amber-100 text-amber-700 @endif
                                ">
                                    {{ ucfirst($item->order->status) }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-slate-500">No orders yet</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

    <!-- Chart Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('revenueChart').getContext('2d');

            // Create gradient
            let gradient = ctx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, 'rgba(99, 102, 241, 0.5)'); // Indigo
            gradient.addColorStop(1, 'rgba(99, 102, 241, 0.0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartLabels) !!},
                    datasets: [{
                        label: 'Revenue ($)',
                        data: {!! json_encode($chartData) !!},
                        borderColor: '#6366f1',
                        backgroundColor: gradient,
                        borderWidth: 3,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#6366f1',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
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
                        },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            titleFont: {
                                family: 'Outfit',
                                size: 13
                            },
                            bodyFont: {
                                family: 'Inter',
                                size: 14,
                                weight: 'bold'
                            },
                            padding: 12,
                            cornerRadius: 8,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return '$' + context.parsed.y.toFixed(2);
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#f1f5f9',
                                drawBorder: false,
                            },
                            ticks: {
                                font: {
                                    family: 'Inter',
                                    size: 11
                                },
                                color: '#64748b',
                                callback: function(value) {
                                    return '$' + value;
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false,
                            },
                            ticks: {
                                font: {
                                    family: 'Inter',
                                    size: 11
                                },
                                color: '#64748b'
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                }
            });
        });
    </script>
@endsection
