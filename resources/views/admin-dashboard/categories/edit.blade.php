@extends('admin-dashboard.master')
@section('title', 'Edit Category')
@section('categories active', 'active')

@section('content')
    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900">Edit Category</h3>
                </div>

                <form class="space-y-6" action="{{ route('admin-dashboard.categories.update', $category) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-2">
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" id="name" name="name" value="{{ $category->name }}"
                                class="mt-1 block w-full rounded-md border px-3 py-2" placeholder="Category name" />
                            @error('name')
                                <p class="text-red-700 mt-1">{{ $message }}</p>
                            @enderror

                            <label class="block text-sm font-medium text-gray-700 mt-4"
                                for="description">Description</label>
                            <textarea id="description" name="description" rows="5" placeholder="Short description"
                                class="mt-1 block w-full rounded-md border px-3 py-2">{{ $category->description }}</textarea>
                            @error('description')
                                <p class="text-red-700 mt-1">{{ $message }}</p>
                            @enderror

                            <div class="mt-6 flex items-center gap-3">
                                <a href="{{ route('admin-dashboard.categories.index') }}"
                                    class="px-4 py-2 border rounded-md">Cancel</a>
                                <button type="submit"
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-yellow-600 text-white rounded-md">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Update Category
                                </button>
                            </div>
                        </div>

                        <div class="flex flex-col items-center">
                            <label class="block text-sm font-medium text-gray-700">Current Image</label>
                            <div class="mt-2 w-full">
                                <div <div
                                    class="w-full h-40 bg-gray-50 rounded-xl border border-dashed border-gray-200 flex items-center justify-center overflow-hidden space-x-2">
                                    @if (!empty($category->image))
                                        <img id="currentImage" src="{{ asset('storage/' . $category->image) }}"
                                            alt="{{ $category->name }}" class="object-cover w-1/2 h-full" />
                                    @else
                                        <div id="noImage" class="text-gray-400 p-4 text-center">No image uploaded</div>
                                    @endif
                                    <img id="newImagePreview" src="" alt="New image preview"
                                        class="hidden object-cover w-1/2 h-full border" />
                                </div>

                                <label for="image"
                                    class="mt-3 w-full inline-flex items-center justify-center gap-2 px-3 py-2 rounded-md text-sm font-medium bg-white border hover:bg-gray-50 cursor-pointer">
                                    Choose new image
                                    <input type="file" id="image" name="image" accept="image/*" class="sr-only" />
                                </label>
                                @error('image')
                                    <p class="text-red-700 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const imageInputEdit = document.getElementById('image');
        const currentImage = document.getElementById('currentImage');
        const newPreview = document.getElementById('newImagePreview');

        if (imageInputEdit) {
            imageInputEdit.addEventListener('change', function() {
                const file = this.files[0];
                if (!file) {
                    if (newPreview) {
                        newPreview.src = '';
                        newPreview.classList.add('hidden');
                    }
                    return;
                }
                const reader = new FileReader();
                reader.onload = e => {
                    if (newPreview) {
                        newPreview.src = e.target.result;
                        newPreview.classList.remove('hidden');
                    }
                };
                reader.readAsDataURL(file);
            });
        }
    </script>
@endpush
