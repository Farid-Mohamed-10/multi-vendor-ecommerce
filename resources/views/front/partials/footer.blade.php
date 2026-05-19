<footer class="bg-[#0f172a] text-gray-300">
    @php
        $supportCenterUrl = route('front.support.center');
        $isAuthenticated = auth()->check();
        $user = auth()->user();
        $isBuyer = $isAuthenticated && $user->hasRole('buyer');
        $isSeller = $isAuthenticated && $user->hasRole('seller');
        $isAdmin = $isAuthenticated && $user->hasRole('admin');

        $dashboardUrl = $isAdmin
            ? route('admin-dashboard.index')
            : ($isSeller
                ? route('seller-dashboard.index')
                : ($isBuyer ? route('buyer-dashboard.index') : route('login')));

        $ordersUrl = $isBuyer
            ? route('buyer-dashboard.orders')
            : ($isSeller
                ? route('seller-dashboard.orders.index')
                : ($isAdmin ? route('admin-dashboard.orders.index') : route('login')));

        $accountLinkText = $isAuthenticated ? 'Dashboard' : 'Login';
        $accountUrl = $isAuthenticated ? $dashboardUrl : route('login');
        $secondaryLinkText = $isAuthenticated ? 'My Orders' : 'Register';
        $secondaryUrl = $isAuthenticated ? $ordersUrl : route('register');
        $sellerLinkText = $isSeller ? 'Manage Products' : ($isAuthenticated ? 'Dashboard' : 'Become a Seller');
        $sellerUrl = $isSeller
            ? route('seller-dashboard.products.index')
            : ($isAuthenticated ? $dashboardUrl : route('register'));
    @endphp

    <div class="mx-auto px-6 pt-14 pb-10">
        <!-- Main Grid -->
        <div class="grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-4 lg:gap-8">
            <!-- About -->
            <div>
                <h3 class="mb-3 text-lg font-semibold tracking-wide text-white"
                    style="font-family:'Playfair Display',serif;">About ALOSTORA</h3>
                <p class="mb-5 text-sm leading-relaxed text-gray-400">
                    Egypt's trusted online marketplace offering the lowest prices on fashion, electronics, home
                    goods, and more.
                </p>
                <!-- Social Icons -->
                <div class="flex items-center gap-4">
                    <!-- Facebook -->
                    <a href="https://www.facebook.com/farid.mohamed.96199" aria-label="Facebook" target="_blank"
                        rel="noopener noreferrer"
                        class="text-gray-400 transition-all duration-200 ease-in-out hover:-translate-y-1 hover:text-[#60a5fa]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M22 12a10 10 0 1 0-11.563 9.876v-6.988H7.9V12h2.537V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.888h-2.33v6.988A10.004 10.004 0 0 0 22 12Z" />
                        </svg>
                    </a>
                    <!-- WhatsApp -->
                    <a href="https://wa.me/201029911289" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp"
                        class="text-gray-400 transition-all duration-200 ease-in-out hover:-translate-y-1 hover:text-[#25D366]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M20.52 3.48A11.82 11.82 0 0 0 12.04 0C5.5 0 .17 5.33.17 11.88c0 2.09.55 4.13 1.6 5.93L0 24l6.36-1.67a11.8 11.8 0 0 0 5.68 1.45h.01c6.54 0 11.87-5.33 11.87-11.88 0-3.17-1.23-6.15-3.4-8.42ZM12.05 21.8h-.01a9.8 9.8 0 0 1-5-1.37l-.36-.21-3.78.99 1.01-3.68-.24-.38a9.83 9.83 0 0 1-1.5-5.27c0-5.43 4.42-9.85 9.87-9.85 2.63 0 5.1 1.02 6.96 2.88a9.8 9.8 0 0 1 2.88 6.97c0 5.43-4.42 9.85-9.83 9.85Zm5.4-7.37c-.3-.15-1.77-.87-2.05-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.95 1.17-.17.2-.35.22-.65.07-.3-.15-1.26-.46-2.4-1.47-.89-.79-1.49-1.77-1.66-2.07-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.08-.15-.67-1.62-.92-2.22-.24-.58-.49-.5-.67-.5h-.57c-.2 0-.52.08-.8.37-.27.3-1.05 1.02-1.05 2.5s1.07 2.9 1.22 3.1c.15.2 2.1 3.2 5.08 4.48.71.3 1.27.48 1.7.62.71.22 1.35.19 1.86.12.57-.08 1.77-.72 2.02-1.42.25-.69.25-1.29.17-1.42-.07-.12-.27-.2-.57-.35Z" />
                        </svg>
                    </a>
                    <!-- Instagram -->
                    <a href="https://www.instagram.com/" aria-label="Instagram" target="_blank" rel="noopener noreferrer"
                        class="text-gray-400 transition-all duration-200 ease-in-out hover:-translate-y-1 hover:text-[#60a5fa]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.334 3.608 1.308.975.975 1.246 2.242 1.308 3.608.058 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.062 1.366-.334 2.633-1.308 3.608-.975.975-2.242 1.246-3.608 1.308-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.366-.062-2.633-.334-3.608-1.308-.975-.975-1.246-2.242-1.308-3.608C2.175 15.584 2.163 15.204 2.163 12s.012-3.584.07-4.85c.062-1.366.334-2.633 1.308-3.608C4.516 2.497 5.783 2.225 7.15 2.163 8.416 2.105 8.796 2.163 12 2.163Zm0-2.163C8.741 0 8.332.013 7.052.072 5.197.157 3.355.673 2.014 2.014.673 3.355.157 5.197.072 7.052.013 8.332 0 8.741 0 12c0 3.259.013 3.668.072 4.948.085 1.855.601 3.697 1.942 5.038 1.341 1.341 3.183 1.857 5.038 1.942C8.332 23.987 8.741 24 12 24c3.259 0 3.668-.013 4.948-.072 1.855-.085 3.697-.601 5.038-1.942 1.341-1.341 1.857-3.183 1.942-5.038.059-1.28.072-1.689.072-4.948 0-3.259-.013-3.668-.072-4.948-.085-1.855-.601-3.697-1.942-5.038C20.645.673 18.803.157 16.948.072 15.668.013 15.259 0 12 0Zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324ZM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8Zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881Z" />
                        </svg>
                    </a>
                    <!-- YouTube -->
                    <a href="https://www.youtube.com/" aria-label="YouTube" target="_blank" rel="noopener noreferrer"
                        class="text-gray-400 transition-all duration-200 ease-in-out hover:-translate-y-1 hover:text-[#60a5fa]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814ZM9.545 15.568V8.432L15.818 12l-6.273 3.568Z" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="mb-4 text-base font-semibold tracking-wide text-white">Quick Links</h3>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="{{ route('front.products') }}"
                            class="relative inline-block text-gray-400 transition-[color,padding-left] duration-200 ease-in-out hover:pl-1.5 hover:text-[#60a5fa]">All
                            Products</a></li>
                    <li><a href="{{ $accountUrl }}"
                            class="relative inline-block text-gray-400 transition-[color,padding-left] duration-200 ease-in-out hover:pl-1.5 hover:text-[#60a5fa]">{{ $accountLinkText }}</a>
                    </li>
                    <li><a href="{{ $secondaryUrl }}"
                            class="relative inline-block text-gray-400 transition-[color,padding-left] duration-200 ease-in-out hover:pl-1.5 hover:text-[#60a5fa]">{{ $secondaryLinkText }}</a>
                    </li>
                    <li><a href="{{ $sellerUrl }}"
                            class="relative inline-block text-gray-400 transition-[color,padding-left] duration-200 ease-in-out hover:pl-1.5 hover:text-[#60a5fa]">{{ $sellerLinkText }}</a>
                    </li>
                    <li><a href="{{ route('front.track-order') }}"
                            class="relative inline-block text-gray-400 transition-[color,padding-left] duration-200 ease-in-out hover:pl-1.5 hover:text-[#60a5fa]">Track
                            Order</a></li>
                    <li><a href="{{ $supportCenterUrl }}#help-center"
                            class="relative inline-block text-gray-400 transition-[color,padding-left] duration-200 ease-in-out hover:pl-1.5 hover:text-[#60a5fa]">Help
                            Center</a></li>
                </ul>
            </div>

            <!-- Customer Service -->
            <div>
                <h3 class="mb-4 text-base font-semibold tracking-wide text-white">Customer Service</h3>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="{{ $supportCenterUrl }}#faq"
                            class="relative inline-block text-gray-400 transition-[color,padding-left] duration-200 ease-in-out hover:pl-1.5 hover:text-[#60a5fa]">FAQ</a>
                    </li>
                    <li><a href="{{ $supportCenterUrl }}#returns-refunds"
                            class="relative inline-block text-gray-400 transition-[color,padding-left] duration-200 ease-in-out hover:pl-1.5 hover:text-[#60a5fa]">Returns
                            &amp; Refunds</a>
                    </li>
                    <li><a href="{{ $supportCenterUrl }}#shipping-info"
                            class="relative inline-block text-gray-400 transition-[color,padding-left] duration-200 ease-in-out hover:pl-1.5 hover:text-[#60a5fa]">Shipping
                            Info</a></li>
                    <li><a href="{{ route('policy.show') }}"
                            class="relative inline-block text-gray-400 transition-[color,padding-left] duration-200 ease-in-out hover:pl-1.5 hover:text-[#60a5fa]">Privacy
                            Policy</a></li>
                    <li><a href="{{ route('terms.show') }}"
                            class="relative inline-block text-gray-400 transition-[color,padding-left] duration-200 ease-in-out hover:pl-1.5 hover:text-[#60a5fa]">Terms
                            &amp; Conditions</a>
                    </li>
                </ul>
            </div>

            <!-- Contact Us -->
            <div>
                <h3 class="mb-4 text-base font-semibold tracking-wide text-white">Contact Us</h3>
                <ul class="space-y-3 text-sm">
                    <li>
                        <a href="tel:+201029911289"
                            class="flex items-center gap-3 text-gray-400 transition-colors duration-200 hover:text-[#93c5fd]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 text-blue-400"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 6.338c0-.92.76-1.647 1.68-1.588l2.477.165a1.5 1.5 0 0 1 1.38 1.26l.528 3.167a1.5 1.5 0 0 1-.648 1.53L6.26 12.16a13.514 13.514 0 0 0 5.58 5.58l1.288-1.407a1.5 1.5 0 0 1 1.53-.648l3.167.528a1.5 1.5 0 0 1 1.26 1.38l.165 2.477a1.575 1.575 0 0 1-1.588 1.68C9.315 21.75 2.25 14.685 2.25 6.338Z" />
                            </svg>
                            +201029911289
                        </a>
                    </li>
                    <li>
                        <a href="mailto:fm221210@gmail.com"
                            class="flex items-center gap-3 text-gray-400 transition-colors duration-200 hover:text-[#93c5fd]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 text-blue-400"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25H4.5a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5H4.5a2.25 2.25 0 0 0-2.25 2.25m19.5 0-9.75 6.75L2.25 6.75" />
                            </svg>
                            fm221210@gmail.com
                        </a>
                    </li>
                    <li>
                        <span
                            class="flex cursor-default items-start gap-3 text-gray-400 transition-colors duration-200 hover:text-[#93c5fd]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-4 w-4 shrink-0 text-blue-400"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                            </svg>
                            Hurghada, Egypt
                        </span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Divider -->
        <hr class="mb-6 mt-10 border-white/[0.08]" />

        <!-- Bottom Bar -->
        <div class="text-center text-sm text-gray-500">
            &copy; 2026 ALOSTORA. All rights reserved. Made with
            <span class="mx-1 align-middle text-base text-red-500">&#10084;</span>
            in Egypt
        </div>
    </div>
</footer>
