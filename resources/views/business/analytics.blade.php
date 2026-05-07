@extends('business.layout')

@section('title', 'Business Analytics')

@section('content')
<section class="bg-[#f5f3ef] min-h-screen py-10">
    <div class="max-w-[1200px] mx-auto px-6 lg:px-10">
        <h1 class="font-serif-display text-[32px] text-gray-900 mb-8">Analytics</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <div class="bg-white border border-[#e8e5e0] p-6">
                <p class="text-[10px] font-semibold tracking-[0.15em] uppercase text-gray-500 mb-2">Total Sales</p>
                <p class="text-[24px] font-semibold text-gray-900">${{ number_format($totalSales, 2) }}</p>
            </div>
            <div class="bg-white border border-[#e8e5e0] p-6">
                <p class="text-[10px] font-semibold tracking-[0.15em] uppercase text-gray-500 mb-2">Total Orders</p>
                <p class="text-[24px] font-semibold text-gray-900">{{ $totalOrders }}</p>
            </div>
            <div class="bg-white border border-[#e8e5e0] p-6">
                <p class="text-[10px] font-semibold tracking-[0.15em] uppercase text-gray-500 mb-2">Pending Orders</p>
                <p class="text-[24px] font-semibold text-gray-900">{{ $pendingOrders }}</p>
            </div>
            <div class="bg-white border border-[#e8e5e0] p-6">
                <p class="text-[10px] font-semibold tracking-[0.15em] uppercase text-gray-500 mb-2">Wholesale Revenue</p>
                <p class="text-[24px] font-semibold text-gray-900">${{ number_format($wholesaleRevenue, 2) }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 mb-10">
            <div class="bg-white border border-[#e8e5e0] p-6">
                <h2 class="text-[11px] font-semibold tracking-[0.15em] uppercase text-gray-900 mb-5">Sales Trend (30 days)</h2>
                @if($salesData->count())
                <div class="space-y-3">
                    @foreach($salesData as $d)
                    <div class="flex items-center gap-3">
                        <span class="text-[11px] text-gray-500 w-16 shrink-0">{{ $d->date }}</span>
                        <div class="flex-1 h-2 bg-[#f5f3ef] relative">
                            @php $maxSales = $salesData->max('sales') @endphp
                            <div class="absolute left-0 top-0 h-full bg-[#111]" style="width: {{ $maxSales > 0 ? ($d->sales / $maxSales * 100) : 0 }}%"></div>
                        </div>
                        <span class="text-[11px] font-medium w-16 text-right">${{ number_format($d->sales, 0) }}</span>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-[13px] text-gray-600">No sales data available.</p>
                @endif
            </div>

            <div class="bg-white border border-[#e8e5e0] p-6">
                <h2 class="text-[11px] font-semibold tracking-[0.15em] uppercase text-gray-900 mb-5">Top Products</h2>
                @if($topProducts->count())
                <div class="space-y-3">
                    @foreach($topProducts as $product)
                    <div class="flex items-center justify-between">
                        <span class="text-[13px]">{{ $product->name }}</span>
                        <span class="text-[11px] text-gray-500">{{ $product->order_items_count }} orders</span>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-[13px] text-gray-600">No sales data available.</p>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            <div class="bg-white border border-[#e8e5e0] p-6">
                <h2 class="text-[11px] font-semibold tracking-[0.15em] uppercase text-gray-900 mb-5">Preorder Stats</h2>
                <div class="flex gap-4">
                    @foreach($preorderStats as $status => $count)
                    <div class="text-center px-4 py-3 bg-[#f5f3ef]">
                        <p class="text-[20px] font-semibold">{{ $count }}</p>
                        <p class="text-[10px] font-semibold tracking-[0.1em] uppercase text-gray-500">{{ ucfirst($status) }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white border border-[#e8e5e0] p-6">
                <h2 class="text-[11px] font-semibold tracking-[0.15em] uppercase text-gray-900 mb-5">Customers</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div class="text-center px-4 py-3 bg-[#f5f3ef]">
                        <p class="text-[20px] font-semibold">{{ $customerStats->total_customers ?? 0 }}</p>
                        <p class="text-[10px] font-semibold tracking-[0.1em] uppercase text-gray-500">Total Customers</p>
                    </div>
                    <div class="text-center px-4 py-3 bg-[#f5f3ef]">
                        <p class="text-[20px] font-semibold">{{ $customerStats->wholesale_customers ?? 0 }}</p>
                        <p class="text-[10px] font-semibold tracking-[0.1em] uppercase text-gray-500">Wholesale Buyers</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
