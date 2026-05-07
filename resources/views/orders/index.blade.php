@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<section class="bg-[#f5f3ef] min-h-screen py-10">
    <div class="max-w-[1000px] mx-auto px-6 lg:px-10">
        <h1 class="font-serif-display text-[32px] text-gray-900 mb-8">My Orders</h1>

        @if($orders->count())
        <div class="space-y-4">
            @foreach($orders as $order)
            <div class="bg-white border border-[#e8e5e0] p-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4">
                    <div>
                        <p class="text-[11px] text-gray-500">Order #{{ $order->id }}</p>
                        <p class="text-[13px] font-medium text-gray-900">{{ $order->business->businessProfile?->business_name ?? 'Vendor' }}</p>
                    </div>
                    <div class="text-left sm:text-right mt-2 sm:mt-0">
                        <span class="inline-block text-[10px] font-semibold tracking-[0.1em] uppercase px-2 py-1 border
                            {{ $order->status === 'delivered' || $order->status === 'completed' ? 'border-green-600 text-green-700' : ($order->status === 'cancelled' || $order->status === 'refunded' ? 'border-red-600 text-red-700' : 'border-gray-400 text-gray-600') }}">
                            {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                        </span>
                        <p class="text-[11px] text-gray-500 mt-1">{{ $order->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
                <div class="flex justify-between items-center pt-4 border-t border-[#e8e5e0]">
                    <div class="text-[12px] text-gray-600">
                        {{ $order->items->count() }} item(s) &middot; {{ ucfirst($order->type) }}
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="text-[14px] font-semibold">${{ number_format($order->total, 2) }}</span>
                        <a href="{{ route('orders.show', $order) }}" class="text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-800 hover:text-black underline">View Details</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-10">{{ $orders->links() }}</div>
        @else
        <div class="bg-white border border-[#e8e5e0] p-16 text-center">
            <p class="text-[13px] text-gray-600">No orders yet.</p>
        </div>
        @endif
    </div>
</section>
@endsection
