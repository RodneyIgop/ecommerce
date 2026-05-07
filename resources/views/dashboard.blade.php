@extends('layouts.app')

@section('title', 'PureFit Apparel - Modern Style. Everyday You.')

@section('content')

    <!-- Hero Section -->
    <section class="relative bg-[#f5f3ef] overflow-hidden">
        <div class="max-w-[1400px] mx-auto">
            <div class="grid lg:grid-cols-2 min-h-[600px] lg:min-h-[700px]">
                <!-- Text Content -->
                <div class="flex flex-col justify-center px-6 lg:px-16 py-16 lg:py-0 order-2 lg:order-1 relative z-10">
                    <p class="text-[11px] font-semibold tracking-[0.2em] uppercase text-gray-600 mb-5">
                        Modern Style. Everyday You.
                    </p>
                    <h1 class="font-serif-display text-[48px] sm:text-[60px] lg:text-[72px] leading-[1.05] text-gray-900 mb-6">
                        Made for<br>every moment.
                    </h1>
                    <p class="text-gray-600 text-[15px] leading-relaxed mb-8 max-w-md">
                        Timeless essentials. Thoughtful details.<br>
                        Clothing that fits your life.
                    </p>
                    <div class="flex flex-wrap gap-4 group">
                        <a href="{{ route('products') }}" class="inline-flex items-center justify-center bg-[#111] text-white border border-transparent text-[11px] font-semibold tracking-[0.12em] uppercase px-8 py-3.5 hover:bg-gray-800 transition-colors group-hover:bg-white group-hover:text-black group-hover:border-[#111]">
                            Shop Men
                        </a>
                        <a href="{{ route('products') }}" class="inline-flex items-center justify-center border border-[#111] text-[#111] text-[11px] font-semibold tracking-[0.12em] uppercase px-8 py-3.5 hover:bg-[#111] hover:text-white transition-colors">
                            Shop Women
                        </a>
                    </div>
                </div>

                <!-- Hero Image -->
                <div class="relative order-1 lg:order-2 h-[400px] lg:h-auto">
                    <img src="https://images.unsplash.com/photo-1516826957135-700dedea698c?w=900&h=900&fit=crop&crop=faces" 
                         alt="Fashion models wearing modern casual clothing" 
                         class="absolute inset-0 w-full h-full object-cover">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Bar -->
    <section class="bg-[#ebe8e3] py-10 lg:py-12">
        <div class="max-w-[1400px] mx-auto px-6 lg:px-10">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-6">
                <!-- Feature 1 -->
                <div class="flex items-start gap-4">
                    <div class="shrink-0 mt-0.5">
                        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 0 0 1.5-.189m-1.5.189a6.01 6.01 0 0 1-1.5-.189m3.75 7.478a12.06 12.06 0 0 1-4.5 0m3.75 2.383a14.406 14.406 0 0 1-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 1 0-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-900 mb-1">Sustainable Materials</h3>
                        <p class="text-[13px] text-gray-600 leading-snug">Better for you, better for<br>the planet.</p>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="flex items-start gap-4">
                    <div class="shrink-0 mt-0.5">
                        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0 1 12 21 8.25 8.25 0 0 1 6.038 7.047 8.287 8.287 0 0 0 9 9.601a8.983 8.983 0 0 1 3.361-6.867 8.21 8.21 0 0 0 3 2.48Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 18a3.75 3.75 0 0 0 .495-7.468 5.99 5.99 0 0 0-1.925 3.547 5.974 5.974 0 0 1-2.63-3.547 5.99 5.99 0 0 0-1.925 3.468A3.75 3.75 0 0 0 12 18Z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-900 mb-1">Timeless Design</h3>
                        <p class="text-[13px] text-gray-600 leading-snug">Pieces you'll wear today<br>and for years to come.</p>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="flex items-start gap-4">
                    <div class="shrink-0 mt-0.5">
                        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-900 mb-1">Premium Quality</h3>
                        <p class="text-[13px] text-gray-600 leading-snug">Built to last with attention<br>to every detail.</p>
                    </div>
                </div>

                <!-- Feature 4 -->
                <div class="flex items-start gap-4">
                    <div class="shrink-0 mt-0.5">
                        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-900 mb-1">Easy Returns</h3>
                        <p class="text-[13px] text-gray-600 leading-snug">Hassle-free returns<br>within 30 days.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection