@extends('layouts.app')

@section('title', 'Cart')

@section('content')
<section class="bg-[#f5f3ef] min-h-screen py-10">
    <div class="max-w-[1000px] mx-auto px-6 lg:px-10">
        <h1 class="font-serif-display text-[32px] text-gray-900 mb-8">Shopping Cart</h1>

        @if($cart && $cart->items->count())
        <div class="bg-white border border-[#e8e5e0]">
            @foreach($cart->items as $item)
            <div class="flex items-start gap-6 p-6 border-b border-[#e8e5e0] last:border-b-0">
                <div class="w-20 h-20 bg-gray-100 shrink-0">
                    @if($item->product->image)
                        <img src="{{ asset('storage/'.$item->product->image) }}" class="w-full h-full object-cover" alt="">
                    @endif
                </div>
                <div class="flex-1">
                    <h3 class="text-[14px] font-medium text-gray-900">{{ $item->product->name }}</h3>
                    <p class="text-[11px] text-gray-500">{{ $item->product->business->businessProfile?->business_name ?? 'Vendor' }}</p>
                    @if($item->variant)
                        <p class="text-[11px] text-gray-500 mt-1">{{ $item->variant->name }}</p>
                    @endif
                    <p class="text-[10px] font-semibold tracking-[0.1em] uppercase text-gray-500 mt-1">{{ $item->type }}</p>
                </div>
                <div class="text-right">
                    <form action="{{ route('cart.update', $item) }}" method="post" class="flex items-center gap-2 mb-2">
                        @csrf
                        @method('patch')
                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="w-14 bg-transparent border border-[#e8e5e0] text-[12px] py-1 px-2 text-center">
                        <button type="submit" class="text-[11px] text-gray-600 hover:text-black underline">Update</button>
                    </form>
                    <p class="text-[14px] font-semibold text-gray-900">${{ number_format($item->unit_price * $item->quantity, 2) }}</p>
                    @if($item->discount_amount > 0)
                        <p class="text-[11px] text-green-700">Saved ${{ number_format($item->discount_amount, 2) }}</p>
                    @endif
                    <form action="{{ route('cart.remove', $item) }}" method="post" class="mt-2">
                        @csrf
                        @method('delete')
                        <button type="submit" class="text-[11px] text-red-600 hover:text-red-800">Remove</button>
                    </form>
                </div>
            </div>
            @endforeach
            <div class="p-6 bg-[#f5f3ef] border-t border-[#e8e5e0]">
                <div class="flex justify-between text-[13px] mb-2">
                    <span class="text-gray-600">Subtotal</span>
                    <span class="font-medium">${{ number_format($cart->total + $cart->discount_total, 2) }}</span>
                </div>
                @if($cart->discount_total > 0)
                <div class="flex justify-between text-[13px] mb-2">
                    <span class="text-green-700">Discounts</span>
                    <span class="font-medium text-green-700">-${{ number_format($cart->discount_total, 2) }}</span>
                </div>
                @endif
                <div class="flex justify-between text-[13px] mb-2">
                    <span class="text-gray-600">Shipping</span>
                    <span class="font-medium">${{ number_format($cart->shipping_total, 2) }}</span>
                </div>
                <div class="flex justify-between text-[18px] font-semibold text-gray-900 pt-3 border-t border-[#e8e5e0]">
                    <span>Total</span>
                    <span>${{ number_format($cart->total + $cart->shipping_total, 2) }}</span>
                </div>
                <div class="flex gap-3 mt-6">
                    <a href="{{ route('checkout.index') }}" class="flex-1 bg-[#111] text-white text-center text-[11px] font-semibold tracking-[0.12em] uppercase py-4 hover:bg-gray-800 transition-colors">Proceed to Checkout</a>
                    <form action="{{ route('cart.clear') }}" method="post" class="shrink-0">
                        @csrf
                        @method('delete')
                        <button type="submit" class="border border-[#111] text-[#111] text-[11px] font-semibold tracking-[0.12em] uppercase py-4 px-6 hover:bg-[#111] hover:text-white transition-colors">Clear</button>
                    </form>
                </div>
            </div>
        </div>
        @else
        <div class="bg-white border border-[#e8e5e0] p-16 text-center">
            <p class="text-[13px] text-gray-600 mb-6">Your cart is empty.</p>
            <a href="{{ route('products') }}" class="inline-block bg-[#111] text-white text-[11px] font-semibold tracking-[0.12em] uppercase py-3 px-8 hover:bg-gray-800 transition-colors">Continue Shopping</a>
        </div>
        @endif
    </div>
</section>
@endsection
