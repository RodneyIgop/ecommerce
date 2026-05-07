@extends('layouts.app')

@section('title', 'Products')

@section('content')

    <!-- Hero Section -->
    <section class="bg-[#f5f3ef] py-16">
        <div class="max-w-[1400px] mx-auto px-6 lg:px-10">
            <div class="text-center">
                <h1 class="font-serif-display text-[48px] sm:text-[60px] text-gray-900 mb-4">Products</h1>
                <p class="text-gray-600 text-[15px] max-w-2xl mx-auto">
                    Browse our collection of premium clothing and accessories.
                </p>
            </div>
        </div>
    </section>

    <!-- Products Grid -->
    <section class="py-16">
        <div class="max-w-[1400px] mx-auto px-6 lg:px-10">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse ($products as $product)
                    <div class="bg-white border border-[#e8e5e0] group hover:shadow-lg transition-shadow">
                        <div class="aspect-[3/4] overflow-hidden bg-gray-100">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400">
                                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="p-5">
                            <h3 class="text-[14px] font-medium text-gray-900 mb-2">{{ $product->name }}</h3>
                            <p class="text-[13px] text-gray-600 mb-3">{{ Str::limit($product->description, 80) }}</p>
                            <div class="flex items-center justify-between">
                                <span class="text-[11px] px-2 py-1 bg-[#f5f3ef] text-gray-700 rounded-full">{{ $product->category->name ?? 'General' }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-16">
                        <p class="text-gray-500 text-[14px]">No products available at the moment.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

@endsection
