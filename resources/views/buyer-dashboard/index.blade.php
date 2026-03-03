@php
    use App\Models\User;
    use App\Models\Product;
    $users = User::all();
    $products = Product::all();
@endphp

@extends('buyer-dashboard.master')
@section('title', 'My Orders')

@section('my orders active', 'active')

@section('content')
    <main class="flex-1 min-w-0 p-4 sm:p-6 lg:p-8 overflow-hidden">
        <h1 class="text-xl sm:text-2xl font-bold text-gray-800 mb-5 fade-up">My Orders</h1>


    </main>
@endsection
