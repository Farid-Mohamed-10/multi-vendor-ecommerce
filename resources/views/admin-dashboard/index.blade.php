@php
    use App\Models\User;
    use App\Models\Product;
    $users = User::all();
    $products = Product::all();
@endphp

@extends('admin-dashboard..master')
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
                <p class="text-2xl font-bold text-gray-800">{{ $users->count() }}</p>
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
                <p class="text-2xl font-bold text-gray-800">{{ $products->count() }}</p>
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
                <p class="text-2xl font-bold text-gray-800">4565</p>
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
                <p class="text-2xl font-bold text-gray-800">₹8,45,678</p>
            </div>
        </div>

        <!-- CHARTS: 1 col → 2 cols on large screens -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-6">

            <!-- Sales Overview -->
            <div class="bg-white rounded-2xl p-4 sm:p-6 fade-up d5">
                <div class="flex items-center justify-between flex-wrap gap-2 mb-4">
                    <h2 class="text-sm sm:text-base font-bold text-gray-800">Sales Overview</h2>
                    <select
                        class="text-xs text-gray-500 border border-gray-100 rounded-lg px-2 py-1.5 bg-gray-50 focus:outline-none focus:border-purple-300">
                        <option>Last 7 months</option>
                        <option>Last 30 days</option>
                        <option>This year</option>
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
                    <div class="flex flex-col gap-2.5 flex-1 w-full">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2"><span class="category-dot"
                                    style="background:#7C3AED"></span><span class="text-xs text-gray-600">Women
                                    Fashion</span></div><span class="text-xs font-bold text-gray-800">35%</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2"><span class="category-dot"
                                    style="background:#EC4899"></span><span class="text-xs text-gray-600">Men
                                    Fashion</span></div><span class="text-xs font-bold text-gray-800">25%</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2"><span class="category-dot"
                                    style="background:#F59E0B"></span><span class="text-xs text-gray-600">Electronics</span>
                            </div><span class="text-xs font-bold text-gray-800">18%</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2"><span class="category-dot"
                                    style="background:#10B981"></span><span class="text-xs text-gray-600">Home &
                                    Kitchen</span></div><span class="text-xs font-bold text-gray-800">14%</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2"><span class="category-dot"
                                    style="background:#E5E7EB"></span><span class="text-xs text-gray-600">Others</span>
                            </div><span class="text-xs font-bold text-gray-800">8%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- RECENT ORDERS TABLE -->
        <div class="bg-white rounded-2xl p-4 sm:p-6 fade-up">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm sm:text-base font-bold text-gray-800">Recent Orders</h2>
                <button class="text-xs text-purple-600 font-semibold hover:text-purple-800 transition-colors">View
                    All →</button>
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
                        <tr class="hover:bg-purple-50/30 transition-colors">
                            <td class="py-3 pr-4 text-gray-500 font-mono text-xs whitespace-nowrap">#SK-8821</td>
                            <td class="py-3 pr-4 font-medium text-gray-700 whitespace-nowrap">Priya Sharma</td>
                            <td class="py-3 pr-4 text-gray-500 hidden sm:table-cell">Women Fashion</td>
                            <td class="py-3 pr-4 font-semibold text-gray-800 whitespace-nowrap">₹2,340</td>
                            <td class="py-3"><span
                                    class="bg-green-50 text-green-600 text-xs px-2 py-1 rounded-full font-semibold whitespace-nowrap">Delivered</span>
                            </td>
                        </tr>
                        <tr class="hover:bg-purple-50/30 transition-colors">
                            <td class="py-3 pr-4 text-gray-500 font-mono text-xs whitespace-nowrap">#SK-8820</td>
                            <td class="py-3 pr-4 font-medium text-gray-700 whitespace-nowrap">Rahul Mehta</td>
                            <td class="py-3 pr-4 text-gray-500 hidden sm:table-cell">Electronics</td>
                            <td class="py-3 pr-4 font-semibold text-gray-800 whitespace-nowrap">₹15,999</td>
                            <td class="py-3"><span
                                    class="bg-blue-50 text-blue-600 text-xs px-2 py-1 rounded-full font-semibold whitespace-nowrap">Shipped</span>
                            </td>
                        </tr>
                        <tr class="hover:bg-purple-50/30 transition-colors">
                            <td class="py-3 pr-4 text-gray-500 font-mono text-xs whitespace-nowrap">#SK-8819</td>
                            <td class="py-3 pr-4 font-medium text-gray-700 whitespace-nowrap">Anjali Singh</td>
                            <td class="py-3 pr-4 text-gray-500 hidden sm:table-cell">Beauty & Health</td>
                            <td class="py-3 pr-4 font-semibold text-gray-800 whitespace-nowrap">₹870</td>
                            <td class="py-3"><span
                                    class="bg-yellow-50 text-yellow-600 text-xs px-2 py-1 rounded-full font-semibold whitespace-nowrap">Processing</span>
                            </td>
                        </tr>
                        <tr class="hover:bg-purple-50/30 transition-colors">
                            <td class="py-3 pr-4 text-gray-500 font-mono text-xs whitespace-nowrap">#SK-8818</td>
                            <td class="py-3 pr-4 font-medium text-gray-700 whitespace-nowrap">Vikram Nair</td>
                            <td class="py-3 pr-4 text-gray-500 hidden sm:table-cell">Home & Kitchen</td>
                            <td class="py-3 pr-4 font-semibold text-gray-800 whitespace-nowrap">₹5,450</td>
                            <td class="py-3"><span
                                    class="bg-green-50 text-green-600 text-xs px-2 py-1 rounded-full font-semibold whitespace-nowrap">Delivered</span>
                            </td>
                        </tr>
                        <tr class="hover:bg-purple-50/30 transition-colors">
                            <td class="py-3 pr-4 text-gray-500 font-mono text-xs whitespace-nowrap">#SK-8817</td>
                            <td class="py-3 pr-4 font-medium text-gray-700 whitespace-nowrap">Meena Gupta</td>
                            <td class="py-3 pr-4 text-gray-500 hidden sm:table-cell">Kids</td>
                            <td class="py-3 pr-4 font-semibold text-gray-800 whitespace-nowrap">₹1,200</td>
                            <td class="py-3"><span
                                    class="bg-red-50 text-red-500 text-xs px-2 py-1 rounded-full font-semibold whitespace-nowrap">Cancelled</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </main>
@endsection
