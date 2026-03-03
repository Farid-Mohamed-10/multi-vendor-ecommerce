@extends('admin-dashboard.master')
@section('title', 'Category Details')
@section('categories active', 'active')

@section('content')
    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <div class="flex items-start space-x-6">
                    <div
                        class="h-24 w-24 bg-gray-100 rounded-md flex items-center justify-center text-gray-400 overflow-hidden">
                        @if (!empty($category->image))
                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                                class="w-full h-full object-cover" />
                        @else
                            <span class="text-3xl">{{ strtoupper(substr($category->name, 0, 1)) }}</span>
                        @endif
                    </div>
                    <div class="flex-1">
                        <h3 class="text-2xl font-semibold text-gray-900">{{ $category->name }}</h3>
                    </div>
                    <div class="text-right flex">
                        <a href="{{ route('admin-dashboard.categories.index') }}"
                            class="text-blue-600 hover:text-yellow-900 mr-4">Back</a>
                        <a href="{{ route('admin-dashboard.categories.edit', $category) }}"
                            class="text-yellow-600 hover:text-yellow-900 mr-4">Edit</a>
                        <form action="{{ route('admin-dashboard.categories.destroy', $category) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                        </form>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-600">Products</h4>
                        <div class="mt-1 text-gray-900">{{ $category->products->count() }}</div>
                    </div>
                    <div class="md:col-span-2">
                        <h4 class="text-sm font-medium text-gray-600">Description</h4>
                        <div class="mt-1 text-gray-700">{{ $category->description }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
