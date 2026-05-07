@extends('buyer.layout')

@section('title', 'Dashboard')
@section('nav-overview', 'bg-[#f5f3ef] text-gray-900')

@section('content')

    <!-- Header -->
    <div class="mb-8">
        <h1 class="font-serif-display text-[36px] text-gray-900 mb-2">Welcome, {{ auth()->user()->name }}</h1>
        <p class="text-[14px] text-gray-600">Manage your shopping, orders, and payments.</p>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
        <div class="bg-white border border-[#e8e5e0] px-6 py-5">
            <p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Cart Items</p>
            <p class="text-[28px] font-light text-gray-900">0</p>
        </div>
        <div class="bg-white border border-[#e8e5e0] px-6 py-5">
            <p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Active Orders</p>
            <p class="text-[28px] font-light text-gray-900">0</p>
        </div>
        <div class="bg-white border border-[#e8e5e0] px-6 py-5">
            <p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Wishlist</p>
            <p class="text-[28px] font-light text-gray-900">0</p>
        </div>
        <div class="bg-white border border-[#e8e5e0] px-6 py-5">
            <p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Total Spent</p>
            <p class="text-[28px] font-light text-gray-900">₱0.00</p>
        </div>
    </div>

    <!-- Shopping -->
    <div class="bg-white border border-[#e8e5e0] mb-10">
        <div class="px-6 py-4 border-b border-[#e8e5e0] flex items-center justify-between">
            <h2 class="text-[13px] font-semibold tracking-[0.1em] uppercase text-gray-700">Shopping</h2>
            <a href="#" class="text-[12px] font-semibold tracking-[0.1em] uppercase text-gray-800 hover:text-black transition-colors underline underline-offset-4">Browse Products</a>
        </div>
        <div class="p-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Browse Products</p>
                <p class="text-[16px] text-gray-900">Explore our catalog</p>
            </div>
            <div>
                <p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Add to Cart</p>
                <p class="text-[16px] text-gray-900">Max 3 items per product</p>
            </div>
            <div>
                <p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Checkout</p>
                <p class="text-[16px] text-gray-900">Fast and secure</p>
            </div>
        </div>
        <div class="px-6 py-4 border-t border-[#e8e5e0] bg-[#faf9f7]">
            <p class="text-[13px] text-gray-500">Solo buyers are limited to a maximum of 3 pieces per product.</p>
        </div>
    </div>

    <!-- Orders & Wishlist Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
        <!-- Orders -->
        <div class="bg-white border border-[#e8e5e0]">
            <div class="px-6 py-4 border-b border-[#e8e5e0] flex items-center justify-between">
                <h2 class="text-[13px] font-semibold tracking-[0.1em] uppercase text-gray-700">Orders</h2>
                <a href="#" class="text-[12px] font-semibold tracking-[0.1em] uppercase text-gray-800 hover:text-black transition-colors underline underline-offset-4">View all</a>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-[14px] text-gray-600">Order history</span>
                    <span class="text-[14px] font-medium text-gray-900">0 orders</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-[14px] text-gray-600">Tracking status</span>
                    <span class="text-[14px] font-medium text-gray-900">—</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-[14px] text-gray-600">Pending delivery</span>
                    <span class="text-[14px] font-medium text-gray-900">0</span>
                </div>
            </div>
        </div>

        <!-- Wishlist -->
        <div class="bg-white border border-[#e8e5e0]">
            <div class="px-6 py-4 border-b border-[#e8e5e0] flex items-center justify-between">
                <h2 class="text-[13px] font-semibold tracking-[0.1em] uppercase text-gray-700">Wishlist</h2>
                <a href="#" class="text-[12px] font-semibold tracking-[0.1em] uppercase text-gray-800 hover:text-black transition-colors underline underline-offset-4">View saved</a>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-[14px] text-gray-600">Saved items</span>
                    <span class="text-[14px] font-medium text-gray-900">0</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-[14px] text-gray-600">Back in stock alerts</span>
                    <span class="text-[14px] font-medium text-gray-900">0</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Payments -->
    <div class="bg-white border border-[#e8e5e0] mb-10">
        <div class="px-6 py-4 border-b border-[#e8e5e0] flex items-center justify-between">
            <h2 class="text-[13px] font-semibold tracking-[0.1em] uppercase text-gray-700">Payments</h2>
            <a href="#" class="text-[12px] font-semibold tracking-[0.1em] uppercase text-gray-800 hover:text-black transition-colors underline underline-offset-4">Manage methods</a>
        </div>
        <div class="p-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Payment Methods</p>
                <p class="text-[16px] text-gray-900">—</p>
            </div>
            <div>
                <p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Receipts</p>
                <p class="text-[16px] text-gray-900">0 receipts</p>
            </div>
            <div>
                <p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Total Spent</p>
                <p class="text-[16px] text-gray-900">₱0.00</p>
            </div>
        </div>
    </div>

@endsection
