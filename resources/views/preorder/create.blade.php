@extends('layouts.app')

@section('title', 'Preorder '.$product->name)

@section('content')
<section class="bg-[#f5f3ef] min-h-screen py-10">
    <div class="max-w-[600px] mx-auto px-6 lg:px-10">
        <h1 class="font-serif-display text-[28px] text-gray-900 mb-2">Preorder</h1>
        <p class="text-[13px] text-gray-600 mb-8">{{ $product->name }}</p>

        <div class="bg-white border border-[#e8e5e0] p-6 mb-6">
            <div class="flex items-start gap-4">
                <div class="w-20 h-20 bg-gray-100 shrink-0">
                    @if($product->image)
                        <img src="{{ asset('storage/'.$product->image) }}" class="w-full h-full object-cover" alt="">
                    @endif
                </div>
                <div>
                    <h3 class="text-[14px] font-medium text-gray-900">{{ $product->name }}</h3>
                    <p class="text-[13px] font-semibold mt-1">${{ number_format($product->retail_price, 2) }} / unit</p>
                    @if($product->estimated_production_days)
                        <p class="text-[11px] text-gray-500 mt-1">Estimated production: {{ $product->estimated_production_days }} days</p>
                    @endif
                    @if($product->preorder_deposit_percent > 0)
                        <p class="text-[11px] text-green-700 mt-1">Deposit required: {{ $product->preorder_deposit_percent }}%</p>
                    @endif
                </div>
            </div>
        </div>

        <form action="{{ route('preorder.store', $product) }}" method="post" class="bg-white border border-[#e8e5e0] p-6">
            @csrf
            <div class="mb-5">
                <label class="block text-[10px] font-semibold tracking-[0.1em] uppercase text-gray-600 mb-2">Quantity</label>
                <input type="number" name="quantity" value="1" min="1" required class="w-full bg-transparent border border-[#e8e5e0] text-[13px] py-2 px-3 focus:outline-none focus:border-black">
            </div>
            <div class="mb-5">
                <label class="block text-[10px] font-semibold tracking-[0.1em] uppercase text-gray-600 mb-2">Payment</label>
                <select name="payment_type" class="w-full bg-transparent border border-[#e8e5e0] text-[13px] py-2 px-3 focus:outline-none focus:border-black">
                    <option value="full">Full Payment</option>
                    @if($product->preorder_deposit_percent > 0)
                        <option value="deposit">Deposit Only ({{ $product->preorder_deposit_percent }}%)</option>
                    @endif
                </select>
            </div>
            <button type="submit" class="w-full bg-[#111] text-white text-[11px] font-semibold tracking-[0.12em] uppercase py-4 hover:bg-gray-800 transition-colors">Place Preorder</button>
        </form>
    </div>
</section>
@endsection
