@extends('business.layout')

@section('title', 'Preorders')

@section('content')
<section class="bg-[#f5f3ef] min-h-screen py-10">
    <div class="max-w-[1000px] mx-auto px-6 lg:px-10">
        <h1 class="font-serif-display text-[32px] text-gray-900 mb-8">Preorders</h1>

        @if($preorders->count())
        <div class="bg-white border border-[#e8e5e0]">
            @foreach($preorders as $preorder)
            <div class="p-6 border-b border-[#e8e5e0] last:border-b-0">
                <div class="flex items-start justify-between gap-6">
                    <div>
                        <p class="text-[14px] font-medium">{{ $preorder->product->name }}</p>
                        <p class="text-[11px] text-gray-500">Customer: {{ $preorder->user->name }} &middot; Qty: {{ $preorder->quantity }}</p>
                        <p class="text-[11px] text-gray-500 mt-1">Deposit: ${{ number_format($preorder->deposit_paid, 2) }} / ${{ number_format($preorder->full_amount, 2) }}</p>
                        @if($preorder->estimated_fulfillment_date)
                            <p class="text-[11px] text-gray-500">Est. Fulfillment: {{ $preorder->estimated_fulfillment_date->format('M d, Y') }}</p>
                        @endif
                    </div>
                    <div class="text-right shrink-0">
                        <span class="inline-block text-[10px] font-semibold tracking-[0.1em] uppercase px-2 py-1 border
                            {{ $preorder->status === 'fulfilled' ? 'border-green-600 text-green-700' : ($preorder->status === 'cancelled' ? 'border-red-600 text-red-700' : 'border-gray-400 text-gray-600') }}">
                            {{ ucfirst($preorder->status) }}
                        </span>
                        @if($preorder->status === 'queued')
                        <form action="{{ route('business.preorders.fulfill', $preorder) }}" method="post" class="mt-2">
                            @csrf
                            <button type="submit" class="text-[11px] text-gray-600 hover:text-black underline">Fulfill</button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-6">{{ $preorders->links() }}</div>
        @else
        <div class="bg-white border border-[#e8e5e0] p-12 text-center">
            <p class="text-[13px] text-gray-600">No preorders yet.</p>
        </div>
        @endif
    </div>
</section>
@endsection
