@extends('front.master')

@section('title', 'All Categories')

@section('content')
    <div class="p-10">
        <div class="flex justify-between lg:flex-row md:flex-row flex-col gap-3 items-center mb-7">
            <p class="text-2xl font-bold">All Categories</p>
        </div>
        @if (count($categories))
            <div class="flex flex-wrap my-5 gap-4">
                @foreach ($categories as $category)
                    <div class="p-6 bg-white rounded-xl hover:shadow-xl duration-300">
                        <img src="{{ $category->image ? Storage::url($category->image) : 'https://via.placeholder.com/128' }}"
                            alt="{{ $category->name }}" class="w-24 h-24 rounded-xl">
                        <p class="mt-3 ">{{ $category->name }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <div class="py-16 px-6">
                <div
                    class="max-w-md mx-auto text-center bg-gradient-to-br from-purple-50 via-white to-blue-50 rounded-2xl p-12 border-2 border-gray-100">
                    <div class="mb-6 flex justify-center">
                        <div
                            class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-purple-500 to-blue-500 rounded-2xl">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">No Categories Available</h3>
                    <p class="text-gray-600 mb-6">Our team is working hard to bring you a wide variety of categories. Stay
                        tuned!</p>
                    <a href="{{ url('/') }}"
                        class="inline-flex items-center gap-2 px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl">
                        Back to Home
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                </div>
            </div>
        @endif
    </div>
@endsection
