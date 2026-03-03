@extends('admin-dashboard.master')
@section('title', 'Edit Product')
@section('products active', 'active')

@section('content')
    <div class="p-4 sm:p-6 lg:p-8">
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('admin-dashboard.products.index') }}"
                class="p-2 rounded-xl text-gray-400 hover:text-purple-600 hover:bg-purple-50 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-800">Edit Product</h1>
                <p class="text-sm text-gray-400 mt-0.5">Update product details</p>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            <div class="xl:col-span-2">
                <form action="{{ route('admin-dashboard.products.update', $product) }}" method="POST"
                    enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Basic Info --}}
                    <div class="bg-white rounded-2xl p-6" style="box-shadow:0 2px 12px rgba(139,92,246,0.07)">
                        <h2 class="text-sm font-bold text-gray-700 mb-5">Basic Information</h2>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1.5">Name</label>
                                <input type="text" name="name" value="{{ $product->name }}"
                                    class="w-full px-4 py-2.5 rounded-xl text-sm border border-purple-100 bg-purple-50/30 focus:outline-none focus:border-purple-400 focus:bg-white" />
                                @error('name')
                                    <p class="text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label
                                    class="block text-xs font-semibold text-gray-500 uppercase mb-1.5">Description</label>
                                <textarea name="description" rows="4"
                                    class="w-full px-4 py-2.5 rounded-xl text-sm border border-purple-100 bg-purple-50/30 focus:outline-none focus:border-purple-400 focus:bg-white resize-none">
                                    {{ $product->description }}
                                </textarea>
                                @error('description')
                                    <p class="text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1.5">Category</label>
                                <select name="category_id"
                                    class="w-full px-4 py-2.5 rounded-xl text-sm border border-purple-100 bg-purple-50/30 focus:outline-none focus:border-purple-400 focus:bg-white">
                                    <option value="">Select Category</option>
                                    @foreach (\App\Models\Category::all() as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Pricing --}}
                    <div class="bg-white rounded-2xl p-6" style="box-shadow:0 2px 12px rgba(139,92,246,0.07)">
                        <h2 class="text-sm font-bold text-gray-700 mb-5">Price</h2>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">$</span>
                            <input type="number" name="price" step="0.01" value="{{ $product->price }}"
                                class="w-full pl-8 pr-4 py-2.5 rounded-xl text-sm border border-purple-100 bg-purple-50/30 focus:outline-none focus:border-purple-400 focus:bg-white" />
                            @error('price')
                                <p class="text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Stocks --}}
                    <div class="bg-white rounded-2xl p-6" style="box-shadow:0 2px 12px rgba(139,92,246,0.07)">
                        <h2 class="text-sm font-bold text-gray-700 mb-4">Stocks</h2>
                        <div id="stocks-container" class="space-y-3 mb-4">
                            <div class="stock-item flex gap-3">
                                <input type="text" name="stocks[0][size]" placeholder="Size" value="{{ $product->stocks[0]['size'] }}"
                                    class="flex-1 px-4 py-2.5 rounded-xl text-sm border border-purple-100 bg-purple-50/30 focus:outline-none focus:border-purple-400 focus:bg-white" />
                                <input type="text" name="stocks[0][color]" placeholder="Color" value="{{ $product->stocks[0]['color'] }}"
                                    class="flex-1 px-4 py-2.5 rounded-xl text-sm border border-purple-100 bg-purple-50/30 focus:outline-none focus:border-purple-400 focus:bg-white" />
                                <input type="number" name="stocks[0][quantity]" placeholder="Qty" value="{{ $product->stocks[0]['quantity'] }}"
                                    min="1"
                                    class="w-24 px-4 py-2.5 rounded-xl text-sm border border-purple-100 bg-purple-50/30 focus:outline-none focus:border-purple-400 focus:bg-white" />
                                <ul>
                                    @error('stocks[0][size]')
                                        <li class="text-red-600">{{ $message }}</li>
                                    @enderror
                                    @error('stocks[0][color]')
                                        <li class="text-red-600">{{ $message }}</li>
                                    @enderror
                                    @error('stocks[0][quantity]')
                                        <li class="text-red-600">{{ $message }}</li>
                                    @enderror
                                </ul>
                                <button type="button" class="text-gray-400 hover:text-red-500" onclick="removeStock(this)">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <button type="button"
                            class="px-4 py-2 text-sm text-purple-600 border border-purple-200 rounded-xl hover:bg-purple-50"
                            onclick="addStock()">+ Add Stock</button>
                    </div>

                    {{-- Submit --}}
                    <div class="flex gap-2">
                        <button type="submit" class="px-6 py-2.5 rounded-xl text-sm font-semibold text-white"
                            style="background:linear-gradient(135deg,#7C3AED,#EC4899)">Save</button>
                        <a href="{{ route('admin-dashboard.products.index') }}"
                            class="px-6 py-2.5 text-gray-600 hover:text-gray-800">Cancel</a>
                    </div>
                </form>
            </div>

            {{-- Image --}}
            <div>
                <div class="bg-white rounded-2xl p-6" style="box-shadow:0 2px 12px rgba(139,92,246,0.07)">
                    <h2 class="text-sm font-bold text-gray-700 mb-4">Image</h2>
                    <div id="image-preview-container" class="relative w-full h-40 rounded-xl overflow-hidden mb-3">
                        <img id="current-img"
                            src="{{ $product->image ? Storage::url($product->image) : 'https://via.placeholder.com/300' }}"
                            class="w-full h-full object-cover" />
                        <img id="new-img" class="absolute inset-0 w-full h-full object-cover hidden" />
                    </div>
                    <label id="dropzone"
                        class="block text-center px-4 py-2.5 rounded-xl text-sm text-purple-600 border border-purple-200 hover:bg-purple-50 cursor-pointer">
                        Change Image
                        <input type="file" name="image" accept="image/*" class="hidden"
                            onchange="previewImage(event)" />
                    </label>
                    @error('image')
                        <li class="text-red-600">{{ $message }}</li>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            let stockCount = 1;

            function addStock() {
                const html = `
                    <div class="stock-item flex gap-3">
                        <input type="text" name="stocks[${stockCount}][size]" placeholder="Size" required class="flex-1 px-4 py-2.5 rounded-xl text-sm border border-purple-100 bg-purple-50/30 focus:outline-none focus:border-purple-400 focus:bg-white" />
                        <input type="text" name="stocks[${stockCount}][color]" placeholder="Color" required class="flex-1 px-4 py-2.5 rounded-xl text-sm border border-purple-100 bg-purple-50/30 focus:outline-none focus:border-purple-400 focus:bg-white" />
                        <input type="number" name="stocks[${stockCount}][quantity]" placeholder="Qty" min="1" required class="w-24 px-4 py-2.5 rounded-xl text-sm border border-purple-100 bg-purple-50/30 focus:outline-none focus:border-purple-400 focus:bg-white" />
                        <button type="button" class="text-gray-400 hover:text-red-500" onclick="removeStock(this)">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                `;
                document.getElementById('stocks-container').insertAdjacentHTML('beforeend', html);
                stockCount++;
            }

            function removeStock(btn) {
                btn.closest('.stock-item').remove();
            }

            document.getElementById('dropzone').addEventListener('click', () => {
                document.querySelector('input[name="image"]').click();
            });

            function previewImage(event) {
                const [file] = event.target.files;
                if (file) {
                    const newImg = document.getElementById('new-img');
                    newImg.src = URL.createObjectURL(file);
                    newImg.classList.remove('hidden');
                    // hide current image
                    const current = document.getElementById('current-img');
                    current.classList.add('hidden');
                }
            }
        </script>
    @endpush
@endsection
