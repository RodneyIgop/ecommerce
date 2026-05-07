@extends('layouts.app')

@section('title', $product->name)

@section('content')
<section class="bg-[#f5f3ef] min-h-screen py-10">
    <div class="max-w-[1400px] mx-auto px-6 lg:px-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            <!-- Product Image -->
            <div class="aspect-square bg-white border border-[#e8e5e0]">
                @if($product->image)
                    <img src="{{ asset('storage/'.$product->image) }}" class="w-full h-full object-cover" alt="">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-400 text-[11px]">No Image</div>
                @endif
            </div>

            <!-- Product Info -->
            <div class="flex flex-col">
                <p class="text-[10px] font-semibold tracking-[0.15em] uppercase text-gray-500 mb-2">{{ $product->category?->name ?? 'Uncategorized' }}</p>
                <h1 class="font-serif-display text-[32px] text-gray-900 mb-3">{{ $product->name }}</h1>
                <p class="text-[12px] text-gray-600 mb-1">by <a href="{{ route('marketplace.store', $product->business->businessProfile?->getStoreSlug() ?? 'store') }}" class="underline hover:text-black">{{ $product->business->businessProfile?->business_name ?? 'Vendor' }}</a></p>

                <div class="flex items-center gap-3 mb-6">
                    <div class="flex items-center gap-1">
                        @for($i=1;$i<=5;$i++)
                            <svg class="w-4 h-4 {{ $i <= round($avgRating) ? 'text-yellow-500' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                    <span class="text-[11px] text-gray-600">({{ $reviews->total() }} reviews)</span>
                </div>

                <div class="mb-6">
                    <p class="text-[28px] font-semibold text-gray-900" id="display-price">${{ number_format($product->retail_price, 2) }}</p>
                    @if($product->wholesale_price)
                        <p class="text-[12px] text-gray-500 mt-1">Wholesale: ${{ number_format($product->wholesale_price, 2) }} <span class="text-gray-400">(MOQ: {{ $product->moq }})</span></p>
                    @endif
                </div>

                @if($product->discountTiers->count())
                <div class="bg-white border border-[#e8e5e0] p-4 mb-6">
                    <h4 class="text-[10px] font-semibold tracking-[0.12em] uppercase text-gray-600 mb-3">Volume Discounts</h4>
                    <div class="space-y-2">
                        @foreach($product->discountTiers as $tier)
                        <div class="flex justify-between text-[12px]">
                            <span>{{ $tier->min_quantity }}{{ $tier->max_quantity ? '-'.$tier->max_quantity : '+' }} units</span>
                            <span class="font-semibold text-green-700">{{ $tier->discount_percent }}% off</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="mb-6">
                    <h4 class="text-[10px] font-semibold tracking-[0.12em] uppercase text-gray-600 mb-3">Description</h4>
                    <p class="text-[13px] text-gray-700 leading-relaxed">{{ $product->description ?? 'No description available.' }}</p>
                </div>

                @auth
                <form action="{{ route('cart.add') }}" method="post" class="mt-auto">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    @if($product->variants->count())
                    <div class="mb-4">
                        <label class="block text-[10px] font-semibold tracking-[0.12em] uppercase text-gray-600 mb-2">Variant</label>
                        <select name="variant_id" class="w-full bg-white border border-[#e8e5e0] text-[12px] py-2 px-3 focus:outline-none focus:border-black">
                            @foreach($product->variants as $variant)
                                <option value="{{ $variant->id }}">{{ $variant->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    <div class="flex gap-3 mb-4">
                        <div class="w-24">
                            <label class="block text-[10px] font-semibold tracking-[0.12em] uppercase text-gray-600 mb-2">Quantity</label>
                            <input type="number" name="quantity" value="1" min="1" id="qty-input" class="w-full bg-white border border-[#e8e5e0] text-[12px] py-2 px-3 focus:outline-none focus:border-black text-center">
                        </div>
                        <div class="flex-1">
                            <label class="block text-[10px] font-semibold tracking-[0.12em] uppercase text-gray-600 mb-2">Type</label>
                            <select name="type" id="type-input" class="w-full bg-white border border-[#e8e5e0] text-[12px] py-2 px-3 focus:outline-none focus:border-black">
                                <option value="retail">Retail</option>
                                @if($product->is_wholesale_enabled && $product->wholesale_price)
                                    <option value="wholesale">Wholesale</option>
                                @endif
                            </select>
                        </div>
                    </div>

                    @if($product->is_preorder && $product->getAvailableStock() <= 0)
                        <a href="{{ route('preorder.create', $product) }}" class="block w-full bg-[#111] text-white text-center text-[11px] font-semibold tracking-[0.12em] uppercase py-4 hover:bg-gray-800 transition-colors mb-3">Preorder Now</a>
                    @else
                        <button type="submit" class="w-full bg-[#111] text-white text-[11px] font-semibold tracking-[0.12em] uppercase py-4 hover:bg-gray-800 transition-colors mb-3">Add to Cart</button>
                    @endif
                </form>

                <form action="{{ route('wishlist.toggle', $product) }}" method="post" class="inline">
                    @csrf
                    <button type="submit" class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-600 hover:text-black transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4 {{ $isWishlisted ? 'fill-red-500 text-red-500' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/></svg>
                        {{ $isWishlisted ? 'In Wishlist' : 'Add to Wishlist' }}
                    </button>
                </form>
                @else
                    <a href="{{ route('login') }}" class="block w-full bg-[#111] text-white text-center text-[11px] font-semibold tracking-[0.12em] uppercase py-4 hover:bg-gray-800 transition-colors">Log In to Purchase</a>
                @endauth
            </div>
        </div>

        <!-- Reviews -->
        <div class="mt-16">
            <h2 class="font-serif-display text-[24px] text-gray-900 mb-6">Reviews</h2>
            @if($reviews->count())
                <div class="space-y-6">
                    @foreach($reviews as $review)
                    <div class="bg-white border border-[#e8e5e0] p-6">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="flex">
                                @for($i=1;$i<=5;$i++)
                                    <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-500' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                @endfor
                            </div>
                            <span class="text-[11px] text-gray-600">{{ $review->user->name }}</span>
                        </div>
                        <p class="text-[13px] text-gray-700">{{ $review->comment }}</p>
                    </div>
                    @endforeach
                </div>
                {{ $reviews->links() }}
            @else
                <p class="text-[13px] text-gray-600">No reviews yet.</p>
            @endif
        </div>
    </div>
</section>
@endsection
