@php
    $latestProducts = \App\Models\Product::latest()->limit(3)->get();
@endphp

<section class="w-full">
    @if ($latestProducts->isEmpty())
        <!-- Empty State Section -->
        <div
            class="relative w-full h-96 sm:h-[500px] lg:h-[600px] bg-gradient-to-br from-purple-50 via-white to-blue-50 flex items-center justify-center">
            <div class="absolute inset-0 opacity-10">
                <div
                    class="absolute top-10 left-10 w-40 h-40 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl">
                </div>
                <div
                    class="absolute top-40 right-10 w-40 h-40 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl">
                </div>
                <div
                    class="absolute -bottom-8 left-20 w-40 h-40 bg-pink-400 rounded-full mix-blend-multiply filter blur-3xl">
                </div>
            </div>

            <div class="relative z-10 text-center px-6 sm:px-8 max-w-2xl">
                <div class="mb-6 flex justify-center">
                    <div
                        class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-purple-500 to-blue-500 rounded-2xl">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                </div>

                <h2 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-4">Coming Soon!</h2>
                <p class="text-lg sm:text-xl text-gray-600 mb-8 leading-relaxed">
                    We're preparing something amazing for you. Our collection is being curated with the best products to
                    bring you an exceptional shopping experience.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="#"
                        class="inline-flex items-center justify-center gap-2 px-8 py-3 bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl">
                        Notify Me
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </a>
                    <a href="{{ route('front.all-categories') }}"
                        class="inline-flex items-center justify-center gap-2 px-8 py-3 bg-white hover:bg-gray-50 text-gray-900 font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl border-2 border-gray-200">
                        Browse Categories
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                </div>

                <p class="text-sm text-gray-500 mt-8">✨ Premium quality products launching very soon</p>
            </div>
        </div>
    @else
        <div class="relative w-full h-96 sm:h-[500px] lg:h-[600px] " x-data="productSlider()" x-init="init()">

            <!-- Slider Container -->
            <div class="relative w-full h-full">
                @foreach ($latestProducts as $index => $product)
                    <div class="slider-item absolute inset-0 transition-opacity duration-500 ease-in-out"
                        :class="currentSlide === {{ $index }} ? 'opacity-100' : 'opacity-0 pointer-events-none'">

                        <!-- Background Image -->
                        <div class="absolute inset-0">
                            @if ($product->image)
                                <img src="{{ $product->image ? Storage::url($product->image) : 'https://via.placeholder.com/128' }}"
                                    alt="{{ $product->name }}" class="w-full h-full object-cover">
                            @else
                                <div
                                    class="w-full h-full bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                                    <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="m2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Dark Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-r from-black/60 via-black/40 to-transparent"></div>

                        <!-- Text Content -->
                        <div class="absolute inset-0 flex flex-col justify-center px-6 sm:px-8 lg:px-12 max-w-2xl">
                            <div class="space-y-6">
                                <div>
                                    <p class="text-sm font-semibold text-purple-300 uppercase tracking-wide mb-2">
                                        Featured
                                        Product</p>
                                    <h2
                                        class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-3 leading-tight drop-shadow-lg">
                                        {{ $product->name }}
                                    </h2>
                                    <p
                                        class="text-gray-100 text-base sm:text-lg leading-relaxed max-w-md drop-shadow-md">
                                        {{ Str::limit($product->description ?? 'Discover this amazing product', 150) }}
                                    </p>
                                </div>

                                <!-- Price and Rating -->
                                <div class="flex items-center gap-4">
                                    <div>
                                        <p class="text-sm text-gray-200 font-medium">Price</p>
                                        <p class="text-3xl font-bold text-white drop-shadow-lg">
                                            ₹{{ number_format($product->price, 2) }}</p>
                                    </div>
                                    @if ($product->discount_price)
                                        <div>
                                            <p class="text-sm text-gray-200 font-medium">Regular</p>
                                            <p class="text-xl font-semibold text-gray-300 line-through drop-shadow-md">
                                                ₹{{ number_format($product->discount_price, 2) }}</p>
                                        </div>
                                    @endif
                                </div>

                                <!-- Stock Status -->
                                <div class="flex items-center gap-3">
                                    @if ($product->in_stock ?? true)
                                        <span
                                            class="inline-flex items-center gap-2 px-4 py-2 bg-green-500/90 text-white rounded-full text-sm font-medium backdrop-blur-sm">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            In Stock
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-2 px-4 py-2 bg-red-500/90 text-white rounded-full text-sm font-medium backdrop-blur-sm">
                                            Out of Stock
                                        </span>
                                    @endif
                                </div>

                                <!-- CTA Button -->
                                <div class="flex gap-3 pt-4">
                                    <a href="#"
                                        class="inline-flex items-center gap-2 px-6 sm:px-8 py-3 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl backdrop-blur-sm">
                                        View Product
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Navigation Buttons -->
            @if ($latestProducts->count() > 1)
                <button @click="prevSlide()"
                    class="absolute left-4 sm:left-6 top-1/2 -translate-y-1/2 z-20 bg-white/90 hover:bg-white text-gray-900 rounded-full p-3 transition-all duration-200 shadow-lg hover:shadow-xl group">
                    <svg class="w-6 h-6 group-hover:-translate-x-0.5 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button @click="nextSlide()"
                    class="absolute right-4 sm:right-6 top-1/2 -translate-y-1/2 z-20 bg-white/90 hover:bg-white text-gray-900 rounded-full p-3 transition-all duration-200 shadow-lg hover:shadow-xl group">
                    <svg class="w-6 h-6 group-hover:translate-x-0.5 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                <!-- Dot Indicators -->
                <div class="absolute bottom-6 left-1/2 -translate-x-1/2 z-20 flex gap-2 items-center">
                    @foreach ($latestProducts as $index => $product)
                        <button @click="currentSlide = {{ $index }}"
                            :class="currentSlide === {{ $index }} ? 'bg-purple-600 w-8' :
                                'bg-white/60 hover:bg-white/80 w-2'"
                            class="h-2 rounded-full transition-all duration-300">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>
</section>

<script>
    function productSlider() {
        return {
            currentSlide: 0,
            totalSlides: {{ $latestProducts->count() }},
            autoplayInterval: null,

            init() {
                this.startAutoplay();
            },

            nextSlide() {
                this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
                this.resetAutoplay();
            },

            prevSlide() {
                this.currentSlide = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
                this.resetAutoplay();
            },

            startAutoplay() {
                this.autoplayInterval = setInterval(() => {
                    this.nextSlide();
                }, 5000); // Change slide every 5 seconds
            },

            resetAutoplay() {
                clearInterval(this.autoplayInterval);
                this.startAutoplay();
            },

            destroy() {
                clearInterval(this.autoplayInterval);
            }
        }
    }
</script>
</div>
@endif
</section>
