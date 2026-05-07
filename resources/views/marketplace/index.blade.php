@extends('layouts.app')

@section('title', 'Marketplace')

@section('content')
<section class="bg-[#f5f3ef] min-h-screen py-10">
    <div class="max-w-[1400px] mx-auto px-6 lg:px-10">
        <div class="flex flex-col lg:flex-row gap-10">
            <!-- Filters -->
            <aside class="w-full lg:w-64 shrink-0">
                <div class="bg-white border border-[#e8e5e0] p-6 sticky top-6">
                    <h3 class="text-[11px] font-semibold tracking-[0.15em] uppercase text-gray-900 mb-5">Filters</h3>
                    <form method="get" action="{{ route('marketplace.index') }}" class="space-y-5">
                        @if(request('q'))<input type="hidden" name="q" value="{{ request('q') }}">@endif
                        @if(request('wholesale'))<input type="hidden" name="wholesale" value="1">@endif
                        @if(request('preorder'))<input type="hidden" name="preorder" value="1">@endif

                        <div>
                            <label class="block text-[10px] font-semibold tracking-[0.1em] uppercase text-gray-600 mb-2">Category</label>
                            <select name="category_id" class="w-full bg-transparent border border-[#e8e5e0] text-[12px] py-2 px-3 focus:outline-none focus:border-black">
                                <option value="">All Categories</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-semibold tracking-[0.1em] uppercase text-gray-600 mb-2">Price Range</label>
                            <div class="flex gap-2">
                                <input type="number" name="min_price" placeholder="Min" value="{{ request('min_price') }}" class="w-full bg-transparent border border-[#e8e5e0] text-[12px] py-2 px-3 focus:outline-none focus:border-black">
                                <input type="number" name="max_price" placeholder="Max" value="{{ request('max_price') }}" class="w-full bg-transparent border border-[#e8e5e0] text-[12px] py-2 px-3 focus:outline-none focus:border-black">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10px] font-semibold tracking-[0.1em] uppercase text-gray-600 mb-2">Sort</label>
                            <select name="sort" class="w-full bg-transparent border border-[#e8e5e0] text-[12px] py-2 px-3 focus:outline-none focus:border-black">
                                <option value="latest" {{ request('sort')=='latest'?'selected':'' }}>Newest</option>
                                <option value="price_asc" {{ request('sort')=='price_asc'?'selected':'' }}>Price: Low to High</option>
                                <option value="price_desc" {{ request('sort')=='price_desc'?'selected':'' }}>Price: High to Low</option>
                                <option value="popular" {{ request('sort')=='popular'?'selected':'' }}>Popular</option>
                            </select>
                        </div>
                        <button type="submit" class="w-full bg-[#111] text-white text-[11px] font-semibold tracking-[0.12em] uppercase py-3 hover:bg-gray-800 transition-colors">Apply</button>
                    </form>
                </div>
            </aside>

            <!-- Products -->
            <div class="flex-1">
                <div class="flex items-center justify-between mb-8">
                    <h1 class="font-serif-display text-[28px] text-gray-900">
                        {{ request('q') ? 'Search: '.request('q') : (request('wholesale') ? 'Wholesale' : (request('preorder') ? 'Preorder' : 'Marketplace')) }}
                    </h1>
                    <p class="text-[11px] text-gray-600 tracking-wide">{{ $products->total() }} items</p>
                </div>

                @if($products->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($products as $product)
                    <a href="{{ route('marketplace.show', $product) }}" class="group bg-white border border-[#e8e5e0] hover:border-gray-400 transition-colors">
                        <div class="aspect-square bg-gray-100 overflow-hidden relative">
                            @if($product->image)
                                <img src="{{ asset('storage/'.$product->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400 text-[11px]">No Image</div>
                            @endif
                            @if($product->is_preorder)
                                <span class="absolute top-3 left-3 bg-[#111] text-white text-[9px] font-semibold tracking-[0.1em] uppercase px-2 py-1">Preorder</span>
                            @elseif($product->getAvailableStock() <= 0)
                                <span class="absolute top-3 left-3 bg-gray-500 text-white text-[9px] font-semibold tracking-[0.1em] uppercase px-2 py-1">Out of Stock</span>
                            @endif
                            @if($product->is_wholesale_enabled && $product->wholesale_price)
                                <span class="absolute top-3 right-3 bg-white text-[#111] text-[9px] font-semibold tracking-[0.1em] uppercase px-2 py-1 border border-[#e8e5e0]">Wholesale</span>
                            @endif
                        </div>
                        <div class="p-5">
                            <p class="text-[10px] font-semibold tracking-[0.1em] uppercase text-gray-500 mb-1">{{ $product->category?->name ?? 'Uncategorized' }}</p>
                            <h3 class="text-[14px] font-medium text-gray-900 mb-2 group-hover:underline">{{ $product->name }}</h3>
                            <p class="text-[12px] text-gray-600 mb-3">{{ $product->business->businessProfile?->business_name ?? 'Vendor' }}</p>
                            <div class="flex items-center justify-between">
                                <span class="text-[14px] font-semibold text-gray-900">${{ number_format($product->retail_price, 2) }}</span>
                                @if($product->wholesale_price)
                                    <span class="text-[11px] text-gray-500">WS: ${{ number_format($product->wholesale_price, 2) }}</span>
                                @endif
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
                <div class="mt-10">
                    {{ $products->links() }}
                </div>
                @else
                <div class="bg-white border border-[#e8e5e0] p-16 text-center">
                    <p class="text-[13px] text-gray-600">No products found matching your criteria.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
