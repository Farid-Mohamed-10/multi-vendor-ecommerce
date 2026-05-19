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
                        </div>
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

                        <div class="flex items-baseline gap-3 mb-1">
                            <span class="text-3xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                        </div>
                        <p class="text-xs text-gray-500 mb-5">Inclusive of all taxes</p>

                        <div class="border-t border-gray-100 my-5"></div>

                        @php $totalStock = $product->stocks->sum('quantity'); @endphp

                        {{-- Stock Status --}}
                        <div class="mb-5">
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

                        @if ($totalStock > 0)
                            @if (! auth()->check() || ! auth()->user()->hasRole('seller'))
                            <form action="{{ route('front.cart.add') }}" method="POST" id="addToCartForm">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="stock_id" id="stock_id" value="">
                                <input type="hidden" name="buy_now" id="buy_now" value="0">

                                {{-- SIZE BUTTONS --}}
                                <div class="mb-5">
                                    <p class="text-sm font-semibold text-gray-700 mb-2">Size</p>
                                    <div id="sizesWrap" class="flex flex-wrap gap-2">
                                        @foreach ($sizes as $size)
                                            <button type="button"
                                                class="size-btn px-3 py-2 rounded-xl border border-gray-200 text-sm font-medium hover:border-indigo-500 hover:bg-indigo-50 transition"
                                                data-size="{{ $size }}">
                                                {{ $size }}
                                            </button>
                                        @endforeach
                                    </div>
                                    <p id="sizeHint" class="mt-2 text-sm text-gray-500">Choose a size first.</p>
                                </div>

                                {{-- COLOR CIRCLES --}}
                                <div class="mb-5">
                                    <p class="text-sm font-semibold text-gray-700 mb-2">Color</p>
                                    <div id="colorsWrap" class="flex flex-wrap gap-2">
                                        @foreach ($colors as $color)
                                            <button type="button"
                                                class="color-btn w-10 h-10 rounded-full border border-gray-200 shadow-sm hover:scale-105 transition relative"
                                                data-color="{{ $color }}" title="{{ $color }}">
                                                <span class="absolute inset-1 rounded-full"
                                                    style="background-color: {{ $color }};"></span>
                                            </button>
                                        @endforeach
                                    </div>
                                    <p id="colorHint" class="mt-2 text-sm text-gray-500">Pick a color.</p>
                                </div>

                                {{-- STOCK INFO --}}
                                <div id="stockInfo"
                                    class="mb-5 hidden rounded-xl bg-gray-50 p-3 text-sm text-gray-700 border border-gray-200">
                                </div>

                                @error('stock_id')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                @error('qty')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror

                                @if (session('success'))
                                    <div class="mt-3 rounded-xl bg-green-50 p-3 text-sm text-green-700">
                                        {{ session('success') }}</div>
                                @endif
                                @if (session('error'))
                                    <div class="mt-3 rounded-xl bg-red-50 p-3 text-sm text-red-700">{{ session('error') }}
                                    </div>
                                @endif

                                {{-- QUANTITY --}}
                                <div class="mb-6">
                                    <p class="text-sm font-semibold text-gray-700 mb-2">Quantity</p>
                                    <div class="flex items-center">
                                        <button type="button" onclick="changeQty(-1)"
                                            class="w-10 h-10 flex items-center justify-center border border-gray-300 rounded-l-lg text-gray-600 hover:bg-gray-50 transition-colors font-medium text-lg">−</button>

                                        <input id="qty-input" name="qty" type="number" value="1" min="1"
                                            max="1"
                                            class="w-14 h-10 text-center border-y border-gray-300 text-sm font-semibold focus:outline-none"
                                            readonly />

                                        <button type="button" onclick="changeQty(1)"
                                            class="w-10 h-10 flex items-center justify-center border border-gray-300 rounded-r-lg text-gray-600 hover:bg-gray-50 transition-colors font-medium text-lg">+</button>
                                    </div>
                                </div>

                                {{-- BUTTONS --}}
                                <div class="grid grid-cols-2 gap-3 mb-6">
                                    <button type="submit" id="addBtn"
                                        class="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition disabled:opacity-60 disabled:cursor-not-allowed"
                                        disabled>
                                        Add to Cart
                                    </button>

                                    <button type="button" id="buyNowBtn"
                                        class="w-full py-3 px-4 bg-pink-600 hover:bg-pink-700 text-white text-sm font-semibold rounded-xl transition disabled:opacity-60 disabled:cursor-not-allowed"
                                        disabled>
                                        Buy Now
                                    </button>
                                </div>
                            </form>
                            @else
                                <div class="mb-6 p-4 rounded-xl bg-orange-50 border border-orange-200 text-orange-800 text-sm">
                                    As a seller, you cannot purchase items or add them to your cart.
                                </div>
                            @endif
                        @endif

                        {{-- Secondary Actions --}}
                        <div class="grid grid-cols-2 gap-3 mb-6">
                            @auth
                                @php
                                    $isWishlisted = \App\Models\Wishlist::where('user_id', auth()->id())
                                        ->where('product_id', $product->id)
                                        ->exists();
                                @endphp
                                <form action="{{ route('wishlist.toggle', $product) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="w-full flex items-center justify-center gap-2 py-2.5 px-4 border {{ $isWishlisted ? 'border-red-300 bg-red-50 text-red-600' : 'border-gray-300 hover:border-gray-400 hover:bg-gray-50 text-gray-700' }} text-sm font-medium rounded-xl transition">
                                        <svg class="w-4 h-4" fill="{{ $isWishlisted ? 'currentColor' : 'none' }}"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                        </svg>
                                        {{ $isWishlisted ? 'Wishlisted' : 'Wishlist' }}
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}"
                                    class="flex items-center justify-center gap-2 py-2.5 px-4 border border-gray-300 hover:border-gray-400 hover:bg-gray-50 text-sm font-medium text-gray-700 rounded-xl transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                    </svg>
                                    Wishlist
                                </a>
                            @endauth

                            <button type="button" id="openShare"
                                class="flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2 text-center font-medium text-gray-900 shadow-sm hover:bg-gray-50">
                                Share
                            </button>
                        </div>

                        <div id="shareModal"
                            class="fixed inset-0 z-[70] hidden items-center justify-center bg-slate-900/55 px-4">
                            <div class="w-full max-w-md rounded-[2rem] bg-white p-6 shadow-2xl">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-sky-600">Share
                                        </p>
                                        <h3 class="mt-2 text-2xl font-bold text-slate-900">Share this product</h3>
                                        <p class="mt-2 text-sm text-slate-500">Send this product to your favorite app or
                                            copy the link.</p>
                                    </div>
                                    <button type="button" id="closeShare"
                                        class="rounded-full p-2 text-slate-400 transition hover:bg-slate-100 hover:text-slate-700"
                                        aria-label="Close share dialog">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>

                                <div class="mt-6 grid grid-cols-2 gap-3 sm:grid-cols-3">
                                    <a id="shareWhatsapp" href="#" target="_blank" rel="noopener noreferrer"
                                        class="flex flex-col items-center rounded-2xl border border-slate-200 px-4 py-4 text-sm font-semibold text-slate-700 transition hover:-translate-y-0.5 hover:border-green-200 hover:bg-green-50">
                                        <span
                                            class="mb-2 flex h-11 w-11 items-center justify-center rounded-full bg-green-100 text-green-600">WA</span>
                                        WhatsApp
                                    </a>
                                    <a id="shareFacebook" href="#" target="_blank" rel="noopener noreferrer"
                                        class="flex flex-col items-center rounded-2xl border border-slate-200 px-4 py-4 text-sm font-semibold text-slate-700 transition hover:-translate-y-0.5 hover:border-blue-200 hover:bg-blue-50">
                                        <span
                                            class="mb-2 flex h-11 w-11 items-center justify-center rounded-full bg-blue-100 text-blue-600">f</span>
                                        Facebook
                                    </a>
                                    <a id="shareTelegram" href="#" target="_blank" rel="noopener noreferrer"
                                        class="flex flex-col items-center rounded-2xl border border-slate-200 px-4 py-4 text-sm font-semibold text-slate-700 transition hover:-translate-y-0.5 hover:border-sky-200 hover:bg-sky-50">
                                        <span
                                            class="mb-2 flex h-11 w-11 items-center justify-center rounded-full bg-sky-100 text-sky-600">TG</span>
                                        Telegram
                                    </a>
                                    <a id="shareTwitter" href="#" target="_blank" rel="noopener noreferrer"
                                        class="flex flex-col items-center rounded-2xl border border-slate-200 px-4 py-4 text-sm font-semibold text-slate-700 transition hover:-translate-y-0.5 hover:border-slate-300 hover:bg-slate-50">
                                        <span
                                            class="mb-2 flex h-11 w-11 items-center justify-center rounded-full bg-slate-100 text-slate-700">X</span>
                                        X
                                    </a>
                                    <a id="shareEmail" href="#"
                                        class="flex flex-col items-center rounded-2xl border border-slate-200 px-4 py-4 text-sm font-semibold text-slate-700 transition hover:-translate-y-0.5 hover:border-amber-200 hover:bg-amber-50">
                                        <span
                                            class="mb-2 flex h-11 w-11 items-center justify-center rounded-full bg-amber-100 text-amber-600">@</span>
                                        Email
                                    </a>
                                    <button type="button" id="copyShareLink"
                                        class="flex flex-col items-center rounded-2xl border border-slate-200 px-4 py-4 text-sm font-semibold text-slate-700 transition hover:-translate-y-0.5 hover:border-violet-200 hover:bg-violet-50">
                                        <span
                                            class="mb-2 flex h-11 w-11 items-center justify-center rounded-full bg-violet-100 text-violet-600">⧉</span>
                                        Copy Link
                                    </button>
                                </div>

                                <div class="mt-5 rounded-2xl bg-slate-50 p-3">
                                    <p class="mb-2 text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Link
                                    </p>
                                    <div class="flex items-center gap-2">
                                        <input id="shareProductUrl" type="text" readonly
                                            class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-600 outline-none"
                                            value="{{ route('front.show-product', $product) }}">
                                        <button type="button" id="nativeShare"
                                            class="rounded-xl bg-slate-900 px-3 py-2 text-sm font-semibold text-white transition hover:bg-slate-700">
                                            More
                                        </button>
                                    </div>
                                    <p id="shareFeedback" class="mt-2 hidden text-sm font-medium text-green-600">Link
                                        copied.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        function changeQty(delta) {
            const input = document.getElementById('qty-input');
            const max = parseInt(input.max || '1', 10);
            let val = parseInt(input.value || '1', 10) + delta;
            if (val < 1) val = 1;
            if (val > max) val = max;
            input.value = val;
        }

        (() => {
            const stockMap = @json($stockMap);
            const colorImages = @json($colorImages ?? []); // ✅ اختياري
            const defaultImage = @json($product->image ? asset('storage/' . $product->image) : null);

            const sizeBtns = Array.from(document.querySelectorAll('.size-btn'));
            const colorBtns = Array.from(document.querySelectorAll('.color-btn'));

            const stockIdInput = document.getElementById('stock_id');
            const qtyInput = document.getElementById('qty-input');
            const stockInfo = document.getElementById('stockInfo');

            const addBtn = document.getElementById('addBtn');
            const buyNowBtn = document.getElementById('buyNowBtn');
            const buyNowInput = document.getElementById('buy_now');
            const form = document.getElementById('addToCartForm');

            const sizeHint = document.getElementById('sizeHint');
            const colorHint = document.getElementById('colorHint');

            let selectedSize = '';
            let selectedColor = '';

            function normalize(v) {
                return (v ?? '').toString().trim().toLowerCase();
            }

            function setMainImageByColor(color) {
                const img = document.getElementById('main-image');
                if (!img) return;

                // لو عندك صورة للون
                const direct = colorImages[color] || colorImages[normalize(color)];
                if (direct) {
                    img.src = direct;
                    return;
                }

                // fallback
                if (defaultImage) img.src = defaultImage;
            }

            function resetStockUI(message = '') {
                stockIdInput.value = '';
                qtyInput.value = 1;
                qtyInput.max = 1;

                addBtn.disabled = true;
                buyNowBtn.disabled = true;

                if (message) {
                    stockInfo.textContent = message;
                    stockInfo.classList.remove('hidden');
                } else {
                    stockInfo.classList.add('hidden');
                    stockInfo.textContent = '';
                }
            }

            function updateColorAvailability() {
                // فعّل/اقفل الألوان حسب المقاس المختار
                const availableColors = new Set(
                    stockMap
                    .filter(s => normalize(s.size) === normalize(selectedSize) && Number(s.qty) > 0)
                    .map(s => normalize(s.color))
                );

                colorBtns.forEach(btn => {
                    const c = normalize(btn.dataset.color);
                    const ok = selectedSize && availableColors.has(c);

                    btn.disabled = !ok;
                    btn.classList.toggle('opacity-40', !ok);
                    btn.classList.toggle('cursor-not-allowed', !ok);

                    // لو اللون المختار بقى غير متاح بعد تغيير المقاس
                    if (!ok && normalize(selectedColor) === c) {
                        selectedColor = '';
                        btn.classList.remove('ring-2', 'ring-indigo-600', 'ring-offset-2');
                    }
                });

                if (!selectedSize) {
                    colorHint.textContent = 'Choose size first.';
                } else if (availableColors.size === 0) {
                    colorHint.textContent = 'No colors available for this size.';
                } else {
                    colorHint.textContent = 'Pick a color.';
                }
            }

            function updateStock() {
                resetStockUI();

                if (!selectedSize) {
                    sizeHint.textContent = 'Choose a size first.';
                    updateColorAvailability();
                    return;
                }

                sizeHint.textContent = `Selected: ${selectedSize}`;
                updateColorAvailability();

                if (!selectedColor) {
                    resetStockUI('Now select a color.');
                    return;
                }

                const match = stockMap.find(s =>
                    normalize(s.size) === normalize(selectedSize) &&
                    normalize(s.color) === normalize(selectedColor) &&
                    Number(s.qty) > 0
                );

                if (!match) {
                    resetStockUI('This option is out of stock.');
                    return;
                }

                stockIdInput.value = match.id;
                qtyInput.max = match.qty;
                qtyInput.value = 1;

                addBtn.disabled = false;
                buyNowBtn.disabled = false;

                stockInfo.textContent = `Available: ${match.qty}`;
                stockInfo.classList.remove('hidden');
            }

            // size buttons
            sizeBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    selectedSize = btn.dataset.size;

                    // style
                    sizeBtns.forEach(b => b.classList.remove('border-indigo-500', 'bg-indigo-50'));
                    btn.classList.add('border-indigo-500', 'bg-indigo-50');

                    updateStock();
                });
            });

            // color circles
            colorBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    if (btn.disabled) return;

                    selectedColor = btn.dataset.color;

                    colorBtns.forEach(b => b.classList.remove('ring-2', 'ring-indigo-600',
                        'ring-offset-2'));
                    btn.classList.add('ring-2', 'ring-indigo-600', 'ring-offset-2');

                    setMainImageByColor(selectedColor);
                    updateStock();
                });
            });

            // Buy now
            buyNowBtn.addEventListener('click', () => {
                if (!stockIdInput.value) {
                    resetStockUI('Please choose Size & Color first.');
                    return;
                }
                buyNowInput.value = '1';
                form.submit();
            });

            // Add to cart submit guard
            form.addEventListener('submit', (e) => {
                if (!stockIdInput.value) {
                    e.preventDefault();
                    resetStockUI('Please choose Size & Color first.');
                } else {
                    buyNowInput.value = '0';
                }
            });

            // init
            resetStockUI('Choose a size, then pick a color.');
            updateColorAvailability();
        })();

        (() => {
            const openShare = document.getElementById('openShare');
            const closeShare = document.getElementById('closeShare');
            const shareModal = document.getElementById('shareModal');
            const shareFeedback = document.getElementById('shareFeedback');
            const shareInput = document.getElementById('shareProductUrl');
            const nativeShare = document.getElementById('nativeShare');

            if (!openShare || !shareModal || !shareInput) return;

            const shareUrl = shareInput.value;
            const shareTitle = @json($product->name);
            const shareText = @json('Check out this product on ALOSTORA: ' . $product->name);
            const encodedUrl = encodeURIComponent(shareUrl);
            const encodedText = encodeURIComponent(`${shareText} ${shareUrl}`);
            const encodedTitle = encodeURIComponent(shareTitle);

            document.getElementById('shareWhatsapp').href = `https://wa.me/?text=${encodedText}`;
            document.getElementById('shareFacebook').href =
                `https://www.facebook.com/sharer/sharer.php?u=${encodedUrl}`;
            document.getElementById('shareTelegram').href =
                `https://t.me/share/url?url=${encodedUrl}&text=${encodeURIComponent(shareText)}`;
            document.getElementById('shareTwitter').href =
                `https://twitter.com/intent/tweet?text=${encodeURIComponent(shareText)}&url=${encodedUrl}`;
            document.getElementById('shareEmail').href =
                `mailto:?subject=${encodedTitle}&body=${encodedText}`;

            function hideFeedback() {
                shareFeedback.classList.add('hidden');
            }

            function showFeedback(message) {
                shareFeedback.textContent = message;
                shareFeedback.classList.remove('hidden');
            }

            function openModal() {
                shareModal.classList.remove('hidden');
                shareModal.classList.add('flex');
                document.body.style.overflow = 'hidden';
                hideFeedback();
            }

            function closeModal() {
                shareModal.classList.add('hidden');
                shareModal.classList.remove('flex');
                document.body.style.overflow = '';
            }

            openShare.addEventListener('click', openModal);
            closeShare?.addEventListener('click', closeModal);

            shareModal.addEventListener('click', (event) => {
                if (event.target === shareModal) {
                    closeModal();
                }
            });

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape' && !shareModal.classList.contains('hidden')) {
                    closeModal();
                }
            });

            document.getElementById('copyShareLink')?.addEventListener('click', async () => {
                try {
                    await navigator.clipboard.writeText(shareUrl);
                    showFeedback('Link copied.');
                } catch (error) {
                    shareInput.select();
                    document.execCommand('copy');
                    showFeedback('Link copied.');
                }
            });

            if (navigator.share) {
                nativeShare?.addEventListener('click', async () => {
                    try {
                        await navigator.share({
                            title: shareTitle,
                            text: shareText,
                            url: shareUrl,
                        });
                    } catch (error) {
                        if (error?.name !== 'AbortError') {
                            showFeedback('Unable to open the device share sheet.');
                        }
                    }
                });
            } else if (nativeShare) {
                nativeShare.classList.add('hidden');
            }
        })();
    </script>
@endsection
