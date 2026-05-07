@extends('layouts.app')

@section('title', 'Preorder Details')

@section('content')
<section class="bg-[#f5f3ef] min-h-screen py-10">
    <div class="max-w-[600px] mx-auto px-6 lg:px-10">
        <h1 class="font-serif-display text-[28px] text-gray-900 mb-2">Preorder Details</h1>

        <div class="bg-white border border-[#e8e5e0] p-6 mt-6">
            <div class="flex items-center justify-between mb-6">
                <span class="text-[11px] text-gray-500">#{{ $preorder->id }}</span>
                <span class="inline-block text-[10px] font-semibold tracking-[0.1em] uppercase px-2 py-1 border
                    {{ $preorder->status === 'fulfilled' ? 'border-green-600 text-green-700' : ($preorder->status === 'cancelled' ? 'border-red-600 text-red-700' : 'border-gray-400 text-gray-600') }}">
                    {{ ucfirst($preorder->status) }}
                </span>
            </div>

            <h3 class="text-[16px] font-medium mb-2">{{ $preorder->product->name }}</h3>
            <p class="text-[13px] text-gray-600 mb-4">Quantity: <strong>{{ $preorder->quantity }}</strong></p>
            <p class="text-[13px] text-gray-600 mb-4">Queue Position: <strong>#{{ $position }}</strong></p>

            <div class="pt-4 border-t border-[#e8e5e0]">
                <div class="flex justify-between text-[13px] mb-2">
                    <span class="text-gray-600">Full Amount</span>
                    <span class="font-medium">${{ number_format($preorder->full_amount, 2) }}</span>
                </div>
                @if($preorder->deposit_paid > 0)
                <div class="flex justify-between text-[13px] mb-2">
                    <span class="text-gray-600">Deposit Paid</span>
                    <span class="font-medium">${{ number_format($preorder->deposit_paid, 2) }}</span>
                </div>
                @endif
            </div>

            @if($preorder->estimated_fulfillment_date)
                <p class="text-[11px] text-gray-500 mt-4">Estimated Fulfillment: {{ $preorder->estimated_fulfillment_date->format('F d, Y') }}</p>
            @endif

            @if($preorder->status === 'queued')
            <form action="{{ route('preorder.cancel', $preorder) }}" method="post" class="mt-6">
                @csrf
                <button type="submit" class="w-full border border-red-600 text-red-600 text-[11px] font-semibold tracking-[0.12em] uppercase py-3 hover:bg-red-50 transition-colors">Cancel Preorder</button>
            </form>
            @endif
        </div>
    </div>
</section>
@endsection
