@extends('admin-dashboard.master')
@section('title', 'Products')
@section('products active', 'active')

@section('content')
    <div class="p-4 sm:p-6 lg:p-8">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 flex-wrap gap-3">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-800">Products</h1>
                <p class="text-sm text-gray-400 mt-0.5">Manage your product catalogue</p>
            </div>

            <a href="{{ route('admin-dashboard.products.create') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-white transition-opacity hover:opacity-90"
                style="background:linear-gradient(135deg,#7C3AED,#EC4899)">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Product
            </a>
        </div>

        {{-- search + filters --}}
        <div class="w-full">
            <form action="{{ route('admin-dashboard.products.index') }}" method="GET"
                class="my-3 sm:mt-0 flex flex-col sm:flex-row flex-wrap items-start sm:items-center gap-2 w-full">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search…"
                    class="flex-1 px-4 py-2 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-purple-400" />

                <select name="category_id"
                    class="flex-1 px-4 py-2 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-purple-400">
                    <option value="">All categories</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" @selected(request('category_id') == $cat->id)>{{ $cat->name }}</option>
                    @endforeach
                </select>

                <select name="size"
                    class="flex-1 px-4 py-2 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-purple-400">
                    <option value="">All sizes</option>
                    @foreach ($sizes as $s)
                        <option value="{{ $s }}" @selected(request('size') == $s)>{{ $s }}</option>
                    @endforeach
                </select>

                <button type="submit" class="px-6 py-2 text-sm font-semibold text-white rounded-xl"
                    style="background:linear-gradient(135deg,#7C3AED,#EC4899)">Go</button>
            </form>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-2xl overflow-hidden" style="box-shadow:0 2px 12px rgba(139,92,246,0.07)">
            <div class="table-wrap">
                <table class="w-full text-sm min-w-[800px]">
                    <thead>
                        <tr class="text-left text-xs text-gray-400 border-b border-gray-100">
                            <th class="px-6 py-4 font-medium">#</th>
                            <th class="px-6 py-4 font-medium">Product</th>
                            <th class="px-6 py-4 font-medium">Price</th>
                            <th class="px-6 py-4 font-medium">Category</th>
                            <th class="px-6 py-4 font-medium">Stock</th>
                            <th class="px-6 py-4 font-medium text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        {{-- sample row --}}
                        @forelse ($products as $product)
                            <tr class="hover:bg-purple-50/20 transition-colors">
                                <td class="px-6 py-4 text-gray-400 text-xs font-mono">1</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-9 h-9 rounded-full overflow-hidden bg-gray-100 flex items-center justify-center">
                                            @if (!empty($product->image))
                                                <img src="{{ asset('storage/' . $product->image) }}"
                                                    alt="{{ $product->name }}" class="object-cover w-full h-full" />
                                            @else
                                                {{ strtoupper(substr($product->name, 0, 1)) }}
                                            @endif
                                        </div>
                                        <span class="font-semibold text-gray-700">{{ $product->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-500">${{ $product->price }}</td>
                                <td class="px-6 py-4 text_gray-500">{{ $product->category?->name }}
                                </td>
                                <td class="px-6 py-4 text-gray-500">
                                    {{ $product->stocks->sum('quantity') }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin-dashboard.products.show', $product) }}"
                                            class="p-1.5 rounded-lg text-gray-400 hover:text-purple-600 hover:bg-purple-50 transition-colors"
                                            title="View">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin-dashboard.products.edit', $product) }}"
                                            class="p-1.5 rounded-lg text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition-colors"
                                            title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <button
                                            class="p-1.5 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 transition-colors"
                                            title="Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
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
                                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 012 12V7a2 2 0 012-2z" />
                                            </svg>
                                        </div>
                                        <p class="text-gray-400 text-sm font-medium">No categories found</p>
                                        <a href="{{ route('admin-dashboard.products.create') }}"
                                            class="text-xs text-purple-600 font-semibold hover:underline">
                                            + Add your first category
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- Pagination --}}
            @if ($products->hasPages())
                <div class="px-6 py-4 border-t border-gray-50">
                    {{ $products->links() }}
                </div>
            @endif
        </div>

    </div>
@endsection
