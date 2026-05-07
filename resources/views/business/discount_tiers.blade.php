@extends('business.layout')

@section('title', 'Discount Tiers')

@section('content')
<section class="bg-[#f5f3ef] min-h-screen py-10">
    <div class="max-w-[1000px] mx-auto px-6 lg:px-10">
        <h1 class="font-serif-display text-[32px] text-gray-900 mb-8">Discount Tiers</h1>

        <div class="bg-white border border-[#e8e5e0] p-6 mb-8">
            <h2 class="text-[11px] font-semibold tracking-[0.15em] uppercase text-gray-900 mb-4">Create Tier</h2>
            <form action="{{ route('business.discount_tiers.store') }}" method="post" class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                @csrf
                <div class="sm:col-span-2">
                    <select name="product_id" class="w-full bg-transparent border border-[#e8e5e0] text-[13px] py-2 px-3 focus:outline-none focus:border-black">
                        <option value="">All Products (Business-wide)</option>
                        @foreach($products as $p)
                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex gap-4">
                    <input type="number" name="min_quantity" placeholder="Min Qty" min="1" required class="w-full bg-transparent border border-[#e8e5e0] text-[13px] py-2 px-3 focus:outline-none focus:border-black">
                    <input type="number" name="max_quantity" placeholder="Max Qty (opt)" class="w-full bg-transparent border border-[#e8e5e0] text-[13px] py-2 px-3 focus:outline-none focus:border-black">
                </div>
                <div class="flex gap-3">
                    <input type="number" name="discount_percent" placeholder="%" min="0" max="100" step="0.01" required class="w-full bg-transparent border border-[#e8e5e0] text-[13px] py-2 px-3 focus:outline-none focus:border-black">
                    <button type="submit" class="bg-[#111] text-white text-[11px] font-semibold tracking-[0.12em] uppercase px-4 hover:bg-gray-800 transition-colors shrink-0">Add</button>
                </div>
            </form>
        </div>

        <h2 class="text-[11px] font-semibold tracking-[0.15em] uppercase text-gray-900 mb-4">Existing Tiers</h2>
        @if($tiers->count())
        <div class="bg-white border border-[#e8e5e0]">
            @foreach($tiers as $tier)
            <div class="flex items-center justify-between p-4 border-b border-[#e8e5e0] last:border-b-0">
                <div>
                    <p class="text-[14px] font-medium">{{ $tier->product ? $tier->product->name : 'Business-wide' }}</p>
                    <p class="text-[11px] text-gray-500">{{ $tier->min_quantity }}{{ $tier->max_quantity ? '-'.$tier->max_quantity : '+' }} units</p>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-[14px] font-semibold text-green-700">{{ $tier->discount_percent }}%</span>
                    <span class="text-[10px] font-semibold tracking-[0.1em] uppercase px-2 py-1 border {{ $tier->is_active ? 'border-green-600 text-green-700' : 'border-gray-400 text-gray-500' }}">
                        {{ $tier->is_active ? 'Active' : 'Inactive' }}
                    </span>
                    <form action="{{ route('business.discount_tiers.toggle', $tier) }}" method="post">
                        @csrf
                        @method('patch')
                        <button type="submit" class="text-[11px] text-gray-600 hover:text-black underline">Toggle</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="bg-white border border-[#e8e5e0] p-12 text-center">
            <p class="text-[13px] text-gray-600">No discount tiers configured.</p>
        </div>
        @endif
    </div>
</section>
@endsection
