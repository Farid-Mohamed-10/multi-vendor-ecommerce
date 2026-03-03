@extends('admin-dashboard.master')
@section('title', 'Product Details')
@section('products active', 'active')

@section('content')
    <div class="p-4 sm:p-6 lg:p-8">
        <div class="flex items-center justify-between mb-6 flex-wrap gap-3">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin-dashboard.products.index') }}"
                    class="p-2 rounded-xl text-gray-400 hover:text-purple-600 hover:bg-purple-50 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-800">Product Details</h1>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin-dashboard.products.edit', $product) }}"
                    class="px-4 py-2.5 text-white rounded-xl text-sm font-semibold"
                    style="background:linear-gradient(135deg,#7C3AED,#EC4899)">Edit</a>
                <form action="{{ route('admin-dashboard.products.destroy', $product) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button
                        class="px-4 py-2.5 text-red-500 border border-red-200 rounded-xl text-sm font-semibold hover:bg-red-50">Delete</button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            <div class="xl:col-span-2 space-y-6">
                {{-- Product Info --}}
                <div class="bg-white rounded-2xl p-6" style="box-shadow:0 2px 12px rgba(139,92,246,0.07)">
                    <div class="flex gap-6">
                        <img src="{{ $product->image ? Storage::url($product->image) : 'https://via.placeholder.com/128' }}"
                            alt="product" class="w-32 h-32 rounded-xl object-cover" />
                        <div class="flex-1">
                            <h2 class="text-xl font-bold text-gray-800 mb-2">{{ $product->name }}</h2>
                            <p class="text-sm text-gray-500 mb-4">{{ $product->category?->name }}</p>
                            <p class="text-sm text-gray-600 mb-4">{{ $product->description }}</p>
                            <span class="text-2xl font-bold text-gray-800">${{ number_format($product->price, 2) }}</span>
                        </div>
                    </div>
                </div>

                {{-- Stocks Table --}}
                <div class="bg-white rounded-2xl overflow-hidden" style="box-shadow:0 2px 12px rgba(139,92,246,0.07)">
                    <div class="p-6 border-b border-gray-50">
                        <h3 class="text-sm font-bold text-gray-700">Stock Details</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="text-left text-xs text-gray-400 border-b border-gray-50">
                                    <th class="px-6 py-3 font-medium">Size</th>
                                    <th class="px-6 py-3 font-medium">Color</th>
                                    <th class="px-6 py-3 font-medium">Quantity</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach ($product->stocks as $stock)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-3 text-gray-700">{{ $stock->size }}</td>
                                        <td class="px-6 py-3 text-gray-700">{{ $stock->color }}</td>
                                        <td class="px-6 py-3 text-gray-700">{{ $stock->quantity }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Right Column --}}
            <div>
                <div class="bg-white rounded-2xl p-6" style="box-shadow:0 2px 12px rgba(139,92,246,0.07)">
                    <h3 class="text-sm font-bold text-gray-700 mb-4">Information</h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-xs text-gray-400">Description</dt>
                            <dd class="text-sm text-gray-700 font-medium mt-1">{{ $product->description }}</dd>
                        </div>
                        <div class="pt-3 border-t border-gray-50">
                            <dt class="text-xs text-gray-400">Category</dt>
                            <dd class="text-sm text-gray-700 font-medium mt-1">{{ $product->category?->name }}</dd>
                        </div>
                        <div class="pt-3 border-t border-gray-50">
                            <dt class="text-xs text-gray-400">Price</dt>
                            <dd class="text-sm text-gray-700 font-medium mt-1">${{ number_format($product->price, 2) }}
                            </dd>
                        </div>
                        <div class="pt-3 border-t border-gray-50">
                            <dt class="text-xs text-gray-400">Total Stock</dt>
                            <dd class="text-sm text-gray-700 font-medium mt-1">{{ $product->stocks->sum('quantity') }}
                                units</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
@endsection
