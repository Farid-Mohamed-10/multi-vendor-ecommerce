<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// FRONT
Route::name('front.')->group(function () {
    Route::view('/', 'front.index')->name('home');

    // CATEGORIES
    Route::get('/all-categories', [CategoryController::class, 'showAllCategories'])->name('all-categories');

    // PRODUCTS
    Route::get('/products', [ProductController::class, 'showAllProducts'])->name('products');
    Route::get('/show-product/{product:slug}', [ProductController::class, 'showProduct'])->name('show-product');
    });

// ADMIN DASHBOARD
Route::name('admin-dashboard.')->prefix('/admin-dashboard')->middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'role:admin',
])->group(function () {
    Route::view('/', 'admin-dashboard.index')->name('index');

    // USERS
    Route::resource('users', UserController::class);

    // CATEGORIES
    Route::resource('categories', CategoryController::class);

    // PRODUCTS
    Route::resource('products', ProductController::class);

    // ROLES
    Route::resource('roles', RoleController::class);
});

// BUYER DASHBOARD
Route::name('buyer-dashboard.')->prefix('/buyer-dashboard')->middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'role:buyer',
])->group(function () {
    Route::view('/', 'buyer-dashboard.index')->name('index');
});

// SELLER DASHBOARD
