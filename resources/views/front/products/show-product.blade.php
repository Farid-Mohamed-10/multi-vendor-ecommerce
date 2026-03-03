@extends('front.master')
@section('title', $product->name)

@section('content')
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
                <a href="{{ route('front.home') }}" class="hover:text-indigo-600 transition-colors">Home</a>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                @if ($product->category)
                    <a href="{{ route('front.products', ['category' => $product->category->id]) }}"
                        class="hover:text-indigo-600 transition-colors">{{ $product->category->name }}</a>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                @endif
                <span class="text-gray-900 font-medium truncate max-w-xs">{{ $product->name }}</span>
            </nav>

            {{-- Main Product Section --}}
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">

                    {{-- LEFT: Product Image --}}
                    <div class="p-6 lg:p-8 border-b lg:border-b-0 lg:border-r border-gray-100">
                        <div class="relative rounded-xl overflow-hidden bg-gray-50 aspect-square mb-4 group">
                            @if ($product->image)
                                <img id="main-image" src="{{ asset('storage/' . $product->image) }}"
                                    alt="{{ $product->name }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-20 h-20 text-gray-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif

                            @if ($product->old_price && $product->old_price > $product->price)
                                @php $discount = round((($product->old_price - $product->price) / $product->old_price) * 100); @endphp
                                <div
                                    class="absolute top-3 left-3 px-2.5 py-1 bg-red-500 text-white text-xs font-bold rounded-lg">
                                    {{ $discount }}% OFF
                                </div>
                            @endif
                        </div>

                        @if (isset($product->images) && $product->images->count() > 1)
                            <div class="flex gap-3 overflow-x-auto pb-1">
                                @foreach ($product->images as $image)
                                    <button
                                        onclick="document.getElementById('main-image').src='{{ asset('storage/' . $image->path) }}'"
                                        class="flex-shrink-0 w-16 h-16 rounded-lg border-2 border-gray-200 hover:border-indigo-500 overflow-hidden transition-colors duration-150">
                                        <img src="{{ asset('storage/' . $image->path) }}" alt=""
                                            class="w-full h-full object-cover" />
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    {{-- RIGHT: Product Info --}}
                    <div class="p-6 lg:p-8">

                        @if ($product->category)
                            <span
                                class="inline-block px-3 py-1 text-xs font-medium text-indigo-700 bg-indigo-50 border border-indigo-100 rounded-full mb-3">
                                {{ $product->category->name }}
                            </span>
                        @endif

                        <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-3 leading-tight">
                            {{ $product->name }}
                        </h1>

                        {{-- Price --}}
                        <div class="flex items-baseline gap-3 mb-1">
                            <span class="text-3xl font-bold text-gray-900">
                                ${{ number_format($product->price, 2) }}
                            </span>
                        </div>
                        <p class="text-xs text-gray-500 mb-5">Inclusive of all taxes</p>

                        <div class="border-t border-gray-100 my-5"></div>

                        {{-- Seller --}}
                        @if ($product->user)
                            <div class="mb-5">
                                <p class="text-sm text-gray-500">Sold by</p>
                                <p class="text-sm font-semibold text-indigo-600 mt-0.5">{{ $product->user->name }}</p>
                            </div>
                        @endif

                        {{-- Stock Status --}}
                        <div class="mb-5">
                            @php
                                $totalStock = $product->stocks->sum('quantity');
                            @endphp
                            @if ($totalStock > 0)
                                <span class="inline-flex items-center gap-1.5 text-sm font-medium text-green-700">
                                    <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                    In Stock
                                    @if ($totalStock <= 5)
                                        <span class="text-orange-500 font-normal">(Only {{ $totalStock }} left)</span>
                                    @endif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 text-sm font-medium text-red-600">
                                    <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                    Out of Stock
                                </span>
                            @endif
                        </div>

                        {{-- Quantity and Size/Color Selection --}}
                        @php
                            $totalStock = $product->stocks->sum('quantity');
                        @endphp
                        @if ($totalStock > 0)
                            {{-- Size/Color Selection --}}
                            @if ($product->stocks->count() > 0)
                                <div class="mb-6">
                                    <p class="text-sm font-semibold text-gray-700 mb-3">Available Options</p>
                                    <div class="grid grid-cols-2 gap-2 mb-4">
                                        @foreach ($product->stocks->unique('size') as $stock)
                                            <label
                                                class="flex items-center gap-2.5 cursor-pointer p-2 border border-gray-200 rounded-lg hover:border-indigo-500 transition-colors">
                                                <input type="radio" name="stock_id" value="{{ $stock->id }}"
                                                    {{ $loop->first ? 'checked' : '' }} class="w-4 h-4 text-indigo-600" />
                                                <div>
                                                    <p class="text-sm font-medium text-gray-700">{{ $stock->size }}</p>
                                                    <p class="text-xs text-gray-500">{{ $stock->color }}</p>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- Quantity --}}
                            <div class="mb-6">
                                <p class="text-sm font-semibold text-gray-700 mb-2">Quantity</p>
                                <div class="flex items-center">
                                    <button onclick="changeQty(-1)"
                                        class="w-10 h-10 flex items-center justify-center border border-gray-300 rounded-l-lg text-gray-600 hover:bg-gray-50 transition-colors font-medium text-lg">
                                        −
                                    </button>
                                    <input id="qty-input" type="number" value="1" min="1"
                                        max="{{ $totalStock }}"
                                        class="w-14 h-10 text-center border-y border-gray-300 text-sm font-semibold focus:outline-none"
                                        readonly />
                                    <button onclick="changeQty(1)"
                                        class="w-10 h-10 flex items-center justify-center border border-gray-300 rounded-r-lg text-gray-600 hover:bg-gray-50 transition-colors font-medium text-lg">
                                        +
                                    </button>
                                </div>
                            </div>

                            {{-- CTA Buttons --}}
                            <div class="grid grid-cols-2 gap-3 mb-3">
                                <button type="button" onclick="addToCart()"
                                    class="w-full flex items-center justify-center gap-2 py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition-colors duration-150">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    Add to Cart
                                </button>

                                <a href="#"
                                    class="flex items-center justify-center gap-2 py-3 px-4 bg-pink-600 hover:bg-pink-700 text-white text-sm font-semibold rounded-xl transition-colors duration-150">
                                    Buy Now
                                </a>
                            </div>

                            {{-- Secondary Actions --}}
                            <div class="grid grid-cols-2 gap-3 mb-6">
                                <button
                                    class="flex items-center justify-center gap-2 py-2.5 px-4 border border-gray-300 hover:border-gray-400 hover:bg-gray-50 text-sm font-medium text-gray-700 rounded-xl transition-colors duration-150">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                    Wishlist
                                </button>
                                <!-- Share Button -->
                                <button type="button" id="openShare"
                                    class="flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2 text-center font-medium text-gray-900 shadow-sm hover:bg-gray-50">
                                    <!-- icon (optional) -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24"
                                        fill="currentColor">
                                        <path
                                            d="M18 16.08c-.76 0-1.44.3-1.96.77L8.91 12.7a3.27 3.27 0 0 0 0-1.39l7-4.11A2.99 2.99 0 1 0 14 5a2.9 2.9 0 0 0 .04.49l-7 4.11a3 3 0 1 0 0 4.8l7.12 4.17c-.02.14-.04.28-.04.43a3 3 0 1 0 3-3Z" />
                                    </svg>
                                    Share
                                </button>

                                <!-- Modal Backdrop -->
                                <div id="shareModal" class="fixed inset-0 z-50 hidden items-center justify-center"
                                    aria-hidden="true">
                                    <!-- overlay -->
                                    <div id="shareOverlay" class="absolute inset-0 bg-black/50"></div>

                                    <!-- modal -->
                                    <div class="relative w-[92%] max-w-md rounded-2xl bg-white p-5 shadow-xl">
                                        <div class="flex items-start justify-between gap-4">
                                            <div>
                                                <h3 class="text-lg font-semibold text-gray-900">Share this page</h3>
                                                <p class="mt-1 text-sm text-gray-500">Choose where to share the link</p>
                                            </div>

                                            <button type="button" id="closeShare"
                                                class="rounded-lg p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700"
                                                aria-label="Close">
                                                ✕
                                            </button>
                                        </div>

                                        <!-- Share buttons grid -->
                                        <div class="mt-5 grid grid-cols-2 gap-3">
                                            <a id="shareWhatsapp" target="_blank" rel="noopener"
                                                class="flex items-center justify-center rounded-xl border border-gray-200 px-3 py-3 text-sm font-medium hover:bg-gray-50">
                                                WhatsApp
                                            </a>
                                            <a id="shareTelegram" target="_blank" rel="noopener"
                                                class="flex items-center justify-center rounded-xl border border-gray-200 px-3 py-3 text-sm font-medium hover:bg-gray-50">
                                                Telegram
                                            </a>
                                            <a id="shareFacebook" target="_blank" rel="noopener"
                                                class="flex items-center justify-center rounded-xl border border-gray-200 px-3 py-3 text-sm font-medium hover:bg-gray-50">
                                                Facebook
                                            </a>
                                            <a id="shareX" target="_blank" rel="noopener"
                                                class="flex items-center justify-center rounded-xl border border-gray-200 px-3 py-3 text-sm font-medium hover:bg-gray-50">
                                                X (Twitter)
                                            </a>
                                            <a id="shareLinkedIn" target="_blank" rel="noopener"
                                                class="flex items-center justify-center rounded-xl border border-gray-200 px-3 py-3 text-sm font-medium hover:bg-gray-50">
                                                LinkedIn
                                            </a>
                                            <a id="shareEmail"
                                                class="flex items-center justify-center rounded-xl border border-gray-200 px-3 py-3 text-sm font-medium hover:bg-gray-50">
                                                Email
                                            </a>
                                        </div>

                                        <!-- Copy link -->
                                        <div class="mt-4">
                                            <div class="flex gap-2">
                                                <input id="shareUrl"
                                                    class="w-full rounded-xl border border-gray-200 bg-gray-50 px-3 py-2 text-sm text-gray-700"
                                                    readonly />
                                                <button type="button" id="copyShare"
                                                    class="shrink-0 rounded-xl bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800">
                                                    Copy
                                                </button>
                                            </div>

                                            <p id="copyToast" class="mt-2 hidden text-sm text-green-600">Copied!</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Perks --}}
                        <div class="space-y-3 border-t border-gray-100 pt-5">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-gray-400 flex-shrink-0 mt-0.5" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8l1.25 9h11.5L19 8" />
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-gray-800">Free Delivery on orders above $50</p>
                                    <p class="text-xs text-gray-500">Delivery in 3-5 business days</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-gray-400 flex-shrink-0 mt-0.5" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-gray-800">7 Days Easy Return</p>
                                    <p class="text-xs text-gray-500">Return if not satisfied</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-gray-400 flex-shrink-0 mt-0.5" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-gray-800">100% Authentic Product</p>
                                    <p class="text-xs text-gray-500">Verified & quality checked</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Product Description --}}
            @if ($product->description)
                <div class="mt-6 bg-white rounded-2xl border border-gray-200 p-6 lg:p-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Product Description</h2>
                    <div class="prose prose-sm max-w-none text-gray-600 leading-relaxed">
                        {!! nl2br(e($product->description)) !!}
                    </div>
                </div>
            @endif

            {{-- Related Products --}}
            @if (isset($relatedProducts) && $relatedProducts->count() > 0)
                <div class="mt-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Related Products</h2>
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                        @foreach ($relatedProducts as $related)
                            <a href="{{ route('front.show-product', $related->slug) }}"
                                class="group bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-md hover:border-gray-300 transition-all duration-200">
                                <div class="aspect-square bg-gray-50 overflow-hidden">
                                    @if ($related->image)
                                        <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->name }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-3">
                                    <p
                                        class="text-sm font-medium text-gray-800 group-hover:text-indigo-600 line-clamp-2 mb-1 transition-colors">
                                        {{ $related->name }}
                                    </p>
                                    <p class="text-sm font-bold text-gray-900">${{ number_format($related->price, 2) }}
                                    </p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>

    <script>
        function changeQty(delta) {
            const input = document.getElementById('qty-input');
            const max = parseInt(input.max);
            let val = parseInt(input.value) + delta;
            if (val < 1) val = 1;
            if (val > max) val = max;
            input.value = val;
        }

        function addToCart() {
            const stockId = document.querySelector('input[name="stock_id"]:checked')?.value;
            const quantity = document.getElementById('qty-input')?.value || 1;
            if (!stockId) {
                alert('Please select a size');
                return;
            }
            // TODO: Implement cart add logic (e.g., AJAX request or form submission)
            console.log('Add to cart:', {
                stockId,
                quantity
            });
        }

        // For share button
        (() => {
            const modal = document.getElementById('shareModal');
            const openBtn = document.getElementById('openShare');
            const closeBtn = document.getElementById('closeShare');
            const overlay = document.getElementById('shareOverlay');

            const inputUrl = document.getElementById('shareUrl');
            const copyBtn = document.getElementById('copyShare');
            const toast = document.getElementById('copyToast');

            // Use current page
            const rawUrl = window.location.href;
            const pageUrl = encodeURIComponent(rawUrl);
            const title = encodeURIComponent(document.title);

            inputUrl.value = rawUrl;

            // Share links
            document.getElementById('shareWhatsapp').href =
                `https://wa.me/?text=${title}%20${pageUrl}`;

            document.getElementById('shareTelegram').href =
                `https://t.me/share/url?url=${pageUrl}&text=${title}`;

            document.getElementById('shareFacebook').href =
                `https://www.facebook.com/sharer/sharer.php?u=${pageUrl}`;

            document.getElementById('shareX').href =
                `https://twitter.com/intent/tweet?url=${pageUrl}&text=${title}`;

            document.getElementById('shareLinkedIn').href =
                `https://www.linkedin.com/sharing/share-offsite/?url=${pageUrl}`;

            document.getElementById('shareEmail').href =
                `mailto:?subject=${title}&body=${title}%0A${pageUrl}`;

            function openModal() {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                modal.setAttribute('aria-hidden', 'false');
                document.body.classList.add('overflow-hidden'); // prevent background scroll
            }

            function closeModal() {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                modal.setAttribute('aria-hidden', 'true');
                document.body.classList.remove('overflow-hidden');
                toast.classList.add('hidden');
            }

            openBtn.addEventListener('click', openModal);
            closeBtn.addEventListener('click', closeModal);
            overlay.addEventListener('click', closeModal);

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') closeModal();
            });

            copyBtn.addEventListener('click', async () => {
                try {
                    await navigator.clipboard.writeText(rawUrl);
                } catch {
                    // fallback
                    inputUrl.select();
                    document.execCommand('copy');
                    window.getSelection()?.removeAllRanges();
                }
                toast.classList.remove('hidden');
                setTimeout(() => toast.classList.add('hidden'), 1200);
            });
        })();
    </script>

@endsection
