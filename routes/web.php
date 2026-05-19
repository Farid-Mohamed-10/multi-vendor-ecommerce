<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\BuyerDashboardController;
use App\Http\Controllers\BuyerProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SellerDashboardController;
use App\Http\Controllers\SellerOrderController;
use App\Http\Controllers\SellerProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

// FRONT
Route::name('front.')->middleware(['redirect.seller'])->group(function () {
    Route::view('/', 'front.index')->name('home');
    Route::view('/support-center', 'front.support.center')->name('support.center');

    // CATEGORIES
    Route::get('/all-categories', [CategoryController::class, 'showAllCategories'])->name('all-categories');

    // PRODUCTS
    Route::get('/products', [ProductController::class, 'showAllProducts'])->name('products');
    Route::get('/show-product/{product:slug}', [ProductController::class, 'showProduct'])->name('show-product');
    Route::get('/track-order', [OrderController::class, 'trackForm'])->name('track-order');
    Route::post('/track-order', [OrderController::class, 'trackLookup'])->name('track-order.lookup');

    // CART & ORDERS
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::post('add', [CartController::class, 'add'])->name('add');
        Route::get('/', [CartController::class, 'show'])->name('show');
        Route::patch('items/{stockId}', [CartController::class, 'update'])->name('update');
        Route::delete('items/{stockId}', [CartController::class, 'remove'])->name('remove');
    });

    Route::get('checkout', [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('checkout', [CheckoutController::class, 'place'])->name('checkout.place');
    Route::get('order/success/{order}', [CheckoutController::class, 'success'])->name('order.success');
});

// COMMON AUTHENTICATED ROUTES
Route::middleware(['auth'])->group(function () {
    Route::post('/wishlist/toggle/{product}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
});

Route::get('/terms-of-service', function () {
    return view('terms', [
        'terms' => Str::markdown(File::get(resource_path('markdown/terms.md'))),
    ]);
})->name('terms.show');

Route::get('/privacy-policy', function () {
    return view('policy', [
        'policy' => Str::markdown(File::get(resource_path('markdown/policy.md'))),
    ]);
})->name('policy.show');

// ADMIN DASHBOARD
Route::name('admin-dashboard.')->prefix('/admin-dashboard')->middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'role:admin',
])->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('index');

    // USERS
    Route::resource('users', UserController::class);

    // CATEGORIES
    Route::resource('categories', CategoryController::class);

    // PRODUCTS
    Route::resource('products', ProductController::class);

    // ROLES
    Route::resource('roles', RoleController::class);

    // ORDERS
    Route::controller(OrderController::class)->group(function () {
        Route::get('/orders', 'index')->name('orders.index');
        Route::get('/orders/{order}', 'show')->name('orders.show');
        Route::patch('/orders/{order}/status', 'updateStatus')->name('orders.updateStatus');
    });

    // PROFILE
    Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');

    // WISHLIST
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
});

// BUYER DASHBOARD
Route::name('buyer-dashboard.')->prefix('/buyer-dashboard')->middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'role:buyer',
])->group(function () {
    // Overview
    Route::get('/', [BuyerDashboardController::class, 'overview'])->name('index');

    // Orders
    Route::get('/orders', [BuyerDashboardController::class, 'orders'])->name('orders');
    Route::get('/orders/{order}', [BuyerDashboardController::class, 'orderShow'])->name('orders.show');
    Route::patch('/orders/{order}/cancel', [BuyerDashboardController::class, 'cancelOrder'])->name('orders.cancel');

    // Profile
    Route::get('/profile', [BuyerProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [BuyerProfileController::class, 'update'])->name('profile.update');

    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
});

// SELLER DASHBOARD
Route::name('seller-dashboard.')->prefix('/seller-dashboard')->middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'role:seller',
])->group(function () {
    Route::get('/', [SellerDashboardController::class, 'index'])->name('index');

    // ORDERS
    Route::controller(SellerOrderController::class)->group(function () {
        Route::get('/orders', 'index')->name('orders.index');
        Route::patch('/orders/{orderItem}/status', 'updateStatus')->name('orders.updateStatus');
    });

    // PRODUCTS
    Route::resource('products', ProductController::class);

    // Profile
    Route::get('/profile', [SellerProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [SellerProfileController::class, 'update'])->name('profile.update');
});
