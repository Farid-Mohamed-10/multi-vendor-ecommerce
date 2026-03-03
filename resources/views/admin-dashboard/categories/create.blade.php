@extends('admin-dashboard.master')
@section('title', 'Create Category')
@section('categories active', 'active')

@section('content')
    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900">Create Category</h3>
                </div>

                @if (session('error'))
                    <div
                        class="flex items-center gap-3 bg-red-50 border border-red-100 text-red-700 text-sm px-4 py-3 rounded-xl mb-5">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        {{ session('error') }}
                    </div>
                @endif

                <form class="space-y-6" action="{{ route('admin-dashboard.categories.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-2">
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}"
                                class="mt-1 block w-full rounded-md border px-3 py-2" placeholder="Category name" />
                            @error('name')
                                <p class="text-red-700 mt-1">{{ $message }}</p>
                            @enderror

                            <label class="block text-sm font-medium text-gray-700 mt-4"
                                for="description">Description</label>
                            <textarea id="description" name="description" rows="5" placeholder="Short description"
                                class="mt-1 block w-full rounded-md border px-3 py-2">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-700 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex flex-col items-center">
                            <label class="block text-sm font-medium text-gray-700">Image</label>
                            <div class="mt-2 w-full">
                                <div
                                    class="w-full h-40 bg-gray-50 rounded-xl border border-dashed border-gray-200 flex items-center justify-center overflow-hidden">
                                    <img id="imagePreview" src="{{ old('image_preview') ?: '' }}" alt="Preview"
                                        class="hidden object-cover w-full h-full" />
                                    <div id="imagePlaceholder" class="text-center text-gray-400 p-4">
                                        <svg class="mx-auto h-10 w-10 text-gray-300" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 7v4a1 1 0 001 1h3m10 0h3a1 1 0 001-1V7M7 21h10M7 7h10" />
                                        </svg>
                                        <p class="text-xs mt-2">PNG, JPG, GIF up to 2MB</p>
                                    </div>
                                </div>

                                <label for="image"
                                    class="mt-3 w-full inline-flex items-center justify-center gap-2 px-3 py-2 rounded-md text-sm font-medium bg-white border hover:bg-gray-50 cursor-pointer">
                                    Choose image
                                    <input type="file" id="image" name="image" accept="image/*" class="sr-only" />
                                </label>
                                @error('image')
                                    <p class="text-red-700 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end space-x-3">
                        <a href="{{ route('admin-dashboard.categories.index') }}"
                            class="px-4 py-2 border rounded-md">Cancel</a>
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-purple-600 to-pink-500 text-white rounded-md">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Save Category
                        </button>
                    </div>
                </form>

                @push('scripts')
                    <script>
                        const imageInput = document.getElementById('image');
                        const preview = document.getElementById('imagePreview');
                        const placeholder = document.getElementById('imagePlaceholder');

                        imageInput.addEventListener('change', function() {
                            const file = this.files[0];
                            if (!file) {
                                preview.src = '';
                                preview.classList.add('hidden');
                                placeholder.classList.remove('hidden');
                                return;
                            }
                            const reader = new FileReader();
                            reader.onload = e => {
                                preview.src = e.target.result;
                                preview.classList.remove('hidden');
                                placeholder.classList.add('hidden');
                            };
                            reader.readAsDataURL(file);
                        });
                    </script>
                @endpush
            </div>
        </div>
    </div>
@endsection
