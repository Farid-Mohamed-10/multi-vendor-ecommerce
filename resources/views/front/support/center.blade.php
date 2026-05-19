@extends('front.master')

@section('title', 'Support Center')

@section('content')
    <section class="bg-slate-50 px-6 py-16 sm:px-10 lg:px-16">
        <div class="mx-auto max-w-5xl space-y-12">
            <div class="rounded-[2rem] bg-white p-8 shadow-sm ring-1 ring-slate-200 sm:p-10">
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-sky-600">Customer Support</p>
                <h1 class="mt-3 text-4xl font-black tracking-tight text-slate-900 sm:text-5xl">Support Center</h1>
                <p class="mt-4 max-w-3xl text-base leading-7 text-slate-600">
                    Find answers about ordering, shipping, returns, and how to get direct help from ALOSTORA.
                </p>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <article id="faq" class="rounded-[2rem] bg-white p-8 shadow-sm ring-1 ring-slate-200 scroll-mt-28">
                    <h2 class="text-2xl font-bold text-slate-900">FAQ</h2>
                    <div class="mt-5 space-y-4 text-sm leading-7 text-slate-600">
                        <p><strong class="text-slate-900">How can I place an order?</strong><br>Browse products, add items to your cart, and continue to checkout to complete payment and delivery details.</p>
                        <p><strong class="text-slate-900">Do I need an account?</strong><br>You can browse freely, but signing in gives you access to your order history and checkout flow.</p>
                        <p><strong class="text-slate-900">Can sellers buy products?</strong><br>Sellers are redirected to their dashboard, so purchasing is intended for buyer accounts.</p>
                    </div>
                </article>

                <article id="track-order" class="rounded-[2rem] bg-white p-8 shadow-sm ring-1 ring-slate-200 scroll-mt-28">
                    <h2 class="text-2xl font-bold text-slate-900">Track Your Order</h2>
                    <div class="mt-5 space-y-4 text-sm leading-7 text-slate-600">
                        <p>Any customer can track an order using the order number and the email address or phone number used at checkout.</p>
                        <p>
                            <a href="{{ route('front.track-order') }}"
                                class="inline-flex items-center rounded-full bg-slate-900 px-5 py-2 font-semibold text-white transition hover:bg-slate-700">
                                Track an Order
                            </a>
                        </p>
                    </div>
                </article>

                <article id="returns-refunds" class="rounded-[2rem] bg-white p-8 shadow-sm ring-1 ring-slate-200 scroll-mt-28">
                    <h2 class="text-2xl font-bold text-slate-900">Returns &amp; Refunds</h2>
                    <div class="mt-5 space-y-4 text-sm leading-7 text-slate-600">
                        <p>If you need help with a return or refund request, contact support with your order number and product details.</p>
                        <p>Our team will guide you through eligibility, next steps, and refund timing.</p>
                    </div>
                </article>

                <article id="shipping-info" class="rounded-[2rem] bg-white p-8 shadow-sm ring-1 ring-slate-200 scroll-mt-28">
                    <h2 class="text-2xl font-bold text-slate-900">Shipping Info</h2>
                    <div class="mt-5 space-y-4 text-sm leading-7 text-slate-600">
                        <p>Shipping times can vary based on the seller, product availability, and destination.</p>
                        <p>Order updates are shared after checkout so buyers can follow fulfillment progress more easily.</p>
                    </div>
                </article>
            </div>

            <article id="help-center" class="rounded-[2rem] bg-slate-900 p-8 text-slate-100 shadow-sm scroll-mt-28 sm:p-10">
                <h2 class="text-2xl font-bold">Help Center</h2>
                <p class="mt-4 max-w-2xl text-sm leading-7 text-slate-300">
                    If you still need help, reach out directly and include as much detail as possible so support can respond faster.
                </p>
                <div class="mt-6 flex flex-col gap-3 text-sm sm:flex-row sm:flex-wrap">
                    <a href="mailto:fm221210@gmail.com"
                        class="inline-flex items-center rounded-full bg-white px-5 py-2 font-semibold text-slate-900 transition hover:bg-slate-200">
                        fm221210@gmail.com
                    </a>
                    <a href="tel:+201029911289"
                        class="inline-flex items-center rounded-full border border-white/20 px-5 py-2 font-semibold text-white transition hover:bg-white/10">
                        +201029911289
                    </a>
                </div>
            </article>
        </div>
    </section>
@endsection
