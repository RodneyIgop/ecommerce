@extends('business.layout')

@section('title', 'Inventory')

@section('content')
<section class="bg-[#f5f3ef] min-h-screen py-10">
    <div class="max-w-[1200px] mx-auto px-6 lg:px-10">
        <h1 class="font-serif-display text-[32px] text-gray-900 mb-8">Inventory</h1>

        @if($lowStock->count())
        <div class="bg-white border border-red-300 p-6 mb-8">
            <h2 class="text-[11px] font-semibold tracking-[0.15em] uppercase text-red-700 mb-3">Low Stock Alerts</h2>
            <div class="space-y-2">
                @foreach($lowStock as $product)
                <p class="text-[13px]">{{ $product->name }} — Available: {{ $product->getAvailableStock() }} (Stock: {{ $product->stock }}, Reserved: {{ $product->reserved_stock ?? 0 }})</p>
                @endforeach
            </div>
        </div>
        @endif

        <h2 class="text-[11px] font-semibold tracking-[0.15em] uppercase text-gray-900 mb-4">Products</h2>
        @if($products->count())
        <div class="bg-white border border-[#e8e5e0]">
            @foreach($products as $product)
            <div class="p-6 border-b border-[#e8e5e0] last:border-b-0">
                <div class="flex items-start justify-between gap-6">
                    <div class="flex-1">
                        <h3 class="text-[14px] font-medium">{{ $product->name }}</h3>
                        <p class="text-[11px] text-gray-500">SKU: {{ $product->sku ?? 'N/A' }} &middot; Weight: {{ $product->weight ?? 'N/A' }} kg</p>
                        <div class="flex gap-6 mt-3 text-[13px]">
                            <span>Stock: <strong>{{ $product->stock }}</strong></span>
                            <span>Reserved: <strong>{{ $product->reserved_stock ?? 0 }}</strong></span>
                            <span>Available: <strong>{{ $product->getAvailableStock() }}</strong></span>
                        </div>
                    </div>
                    <form action="{{ route('business.inventory.update', $product) }}" method="post" class="flex items-center gap-2 shrink-0">
                        @csrf
                        <input type="number" name="quantity" placeholder="+ / -" class="w-20 bg-transparent border border-[#e8e5e0] text-[13px] py-1 px-2 focus:outline-none focus:border-black">
                        <input type="text" name="reason" placeholder="Reason" class="w-32 bg-transparent border border-[#e8e5e0] text-[13px] py-1 px-2 focus:outline-none focus:border-black">
                        <button type="submit" class="bg-[#111] text-white text-[10px] font-semibold tracking-[0.1em] uppercase px-3 py-2 hover:bg-gray-800 transition-colors">Update</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="bg-white border border-[#e8e5e0] p-12 text-center">
            <p class="text-[13px] text-gray-600">No products in inventory.</p>
        </div>
        @endif

        @if($logs->count())
        <h2 class="text-[11px] font-semibold tracking-[0.15em] uppercase text-gray-900 mt-10 mb-4">History</h2>
        <div class="bg-white border border-[#e8e5e0]">
            @foreach($logs as $log)
            <div class="flex justify-between p-4 border-b border-[#e8e5e0] last:border-b-0 text-[12px]">
                <span class="text-gray-600">{{ ucfirst($log->action) }} — {{ $log->product->name }}</span>
                <span class="font-medium">{{ $log->quantity_change > 0 ? '+' : '' }}{{ $log->quantity_change }} &rarr; {{ $log->stock_after }}</span>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>
@endsection
