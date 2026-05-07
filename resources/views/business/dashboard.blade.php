@extends('business.layout')

@section('title', 'Business Dashboard')
@section('nav-overview', 'bg-[#f5f3ef] text-gray-900')

@section('content')

    <!-- Header -->
    <div class="mb-8">
        <h1 class="font-serif-display text-[36px] text-gray-900 mb-2">Business Dashboard</h1>
        <p class="text-[14px] text-gray-600">
            @if($business)
                {{ $business->business_name }} — Seller Control Panel
            @else
                Welcome, {{ auth()->user()->name }}
            @endif
        </p>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
        <div class="bg-white border border-[#e8e5e0] px-6 py-5">
            <p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Total Products</p>
            <p class="text-[28px] font-light text-gray-900">{{ $totalProducts }}</p>
        </div>
        <div class="bg-white border border-[#e8e5e0] px-6 py-5">
            <p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Retail Orders</p>
            <p class="text-[28px] font-light text-gray-900">{{ $retailOrders }}</p>
        </div>
        <div class="bg-white border border-[#e8e5e0] px-6 py-5">
            <p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">B2B Orders</p>
            <p class="text-[28px] font-light text-gray-900">{{ $b2bOrders }}</p>
        </div>
        <div class="bg-white border border-[#e8e5e0] px-6 py-5">
            <p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Total Earnings</p>
            <p class="text-[28px] font-light text-gray-900">₱{{ number_format($totalEarnings, 2) }}</p>
        </div>
    </div>

    <!-- Product Management -->
    <div class="bg-white border border-[#e8e5e0] mb-10">
        <div class="px-6 py-4 border-b border-[#e8e5e0] flex items-center justify-between">
            <h2 class="text-[13px] font-semibold tracking-[0.1em] uppercase text-gray-700">Product Management</h2>
            <a href="{{ route('business.products') }}" class="text-[12px] font-semibold tracking-[0.1em] uppercase text-gray-800 hover:text-black transition-colors underline underline-offset-4">Add Product</a>
        </div>
        <div class="p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Active Products</p>
                <p class="text-[22px] text-gray-900">{{ $activeProducts }}</p>
            </div>
            <div>
                <p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Out of Stock</p>
                <p class="text-[22px] text-gray-900">{{ $outOfStock }}</p>
            </div>
            <div>
                <p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Retail Price Tiers</p>
                <p class="text-[22px] text-gray-900">{{ $totalProducts }}</p>
            </div>
            <div>
                <p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Wholesale Tiers</p>
                <p class="text-[22px] text-gray-900">{{ $wholesaleListings }}</p>
            </div>
        </div>
        <div class="px-6 py-4 border-t border-[#e8e5e0] bg-[#faf9f7]">
            <p class="text-[13px] text-gray-500">Products will appear here once you start adding inventory.</p>
        </div>
    </div>

    <!-- Sales Panel & Insights Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
        <!-- Sales Panel -->
        <div class="bg-white border border-[#e8e5e0]">
            <div class="px-6 py-4 border-b border-[#e8e5e0]">
                <h2 class="text-[13px] font-semibold tracking-[0.1em] uppercase text-gray-700">Sales Panel</h2>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-[14px] text-gray-600">Retail sales</span>
                    <span class="text-[14px] font-medium text-gray-900">{{ $retailSales }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-[14px] text-gray-600">B2B bulk sales</span>
                    <span class="text-[14px] font-medium text-gray-900">{{ $b2bSales }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-[14px] text-gray-600">Pending commission</span>
                    <span class="text-[14px] font-medium text-gray-900">₱{{ number_format($pendingCommission, 2) }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-[14px] text-gray-600">Available earnings</span>
                    <span class="text-[14px] font-medium text-gray-900">₱{{ number_format($availableEarnings, 2) }}</span>
                </div>
                <div class="pt-2">
                    <a href="{{ route('business.sales') }}" class="inline-flex text-[12px] font-semibold tracking-[0.1em] uppercase text-gray-800 hover:text-black transition-colors underline underline-offset-4">View full sales</a>
                </div>
            </div>
        </div>

        <!-- Insights -->
        <div class="bg-white border border-[#e8e5e0]">
            <div class="px-6 py-4 border-b border-[#e8e5e0]">
                <h2 class="text-[13px] font-semibold tracking-[0.1em] uppercase text-gray-700">Insights</h2>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-[14px] text-gray-600">Best selling product</span>
                    <span class="text-[14px] font-medium text-gray-900">{{ $bestSellingProduct->name ?? '—' }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-[14px] text-gray-600">Solo buyer customers</span>
                    <span class="text-[14px] font-medium text-gray-900">{{ $soloBuyerCustomers }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-[14px] text-gray-600">Business customers</span>
                    <span class="text-[14px] font-medium text-gray-900">{{ $businessCustomers }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-[14px] text-gray-600">Stock performance</span>
                    <span class="text-[14px] font-medium text-gray-900">{{ $outOfStock > 0 ? 'Low' : 'Good' }}</span>
                </div>
                <div class="pt-2">
                    <a href="#" class="inline-flex text-[12px] font-semibold tracking-[0.1em] uppercase text-gray-800 hover:text-black transition-colors underline underline-offset-4">View analytics</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders -->
    <div class="bg-white border border-[#e8e5e0] mb-10">
        <div class="px-6 py-4 border-b border-[#e8e5e0] flex items-center justify-between">
            <h2 class="text-[13px] font-semibold tracking-[0.1em] uppercase text-gray-700">Orders</h2>
            <a href="{{ route('business.orders') }}" class="text-[12px] font-semibold tracking-[0.1em] uppercase text-gray-800 hover:text-black transition-colors underline underline-offset-4">View all orders</a>
        </div>
        <div class="p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Incoming Retail</p>
                <p class="text-[22px] text-gray-900">{{ $incomingRetail }}</p>
            </div>
            <div>
                <p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Bulk Requests</p>
                <p class="text-[22px] text-gray-900">{{ $bulkRequests }}</p>
            </div>
            <div>
                <p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">To Ship</p>
                <p class="text-[22px] text-gray-900">{{ $toShip }}</p>
            </div>
            <div>
                <p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Shipped</p>
                <p class="text-[22px] text-gray-900">{{ $shipped }}</p>
            </div>
        </div>
        <div class="px-6 py-4 border-t border-[#e8e5e0] bg-[#faf9f7]">
            <p class="text-[13px] text-gray-500">New orders will appear here once customers start purchasing.</p>
        </div>
    </div>

    <!-- B2B Marketplace -->
    <div class="bg-white border border-[#e8e5e0] mb-10">
        <div class="px-6 py-4 border-b border-[#e8e5e0] flex items-center justify-between">
            <h2 class="text-[13px] font-semibold tracking-[0.1em] uppercase text-gray-700">B2B Marketplace</h2>
            <a href="#" class="text-[12px] font-semibold tracking-[0.1em] uppercase text-gray-800 hover:text-black transition-colors underline underline-offset-4">Browse wholesale listings</a>
        </div>
        <div class="p-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Wholesale Listings</p>
                <p class="text-[22px] text-gray-900">{{ $wholesaleListings }}</p>
            </div>
            <div>
                <p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Pending Negotiations</p>
                <p class="text-[22px] text-gray-900">{{ $bulkRequests }}</p>
            </div>
            <div>
                <p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Bulk Purchases Made</p>
                <p class="text-[22px] text-gray-900">{{ $b2bOrders }}</p>
            </div>
        </div>
        <div class="px-6 py-4 border-t border-[#e8e5e0] bg-[#faf9f7]">
            <p class="text-[13px] text-gray-500">Browse and negotiate wholesale listings from other businesses.</p>
        </div>
    </div>

@endsection
