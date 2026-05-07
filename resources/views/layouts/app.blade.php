<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PureFit Apparel') — PureFit Apparel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .font-serif-display { font-family: 'Instrument Serif', serif; }
        .font-sans-body { font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; }
    </style>
</head>
<body class="font-sans-body text-gray-900 antialiased">

    <!-- Navigation -->
    <nav class="bg-[#f5f3ef] border-b border-[#e8e5e0]">
        <div class="max-w-[1400px] mx-auto px-6 lg:px-10">
            <div class="flex items-center justify-between h-[70px]">
                <!-- Left Links -->
                <div class="hidden md:flex items-center gap-8">
                    <a href="{{ route('products') }}" class="text-[11px] font-medium tracking-[0.12em] uppercase text-gray-800 hover:text-black transition-colors">Men</a>
                    <a href="{{ route('products') }}" class="text-[11px] font-medium tracking-[0.12em] uppercase text-gray-800 hover:text-black transition-colors">Women</a>
                    <a href="{{ route('products') }}" class="text-[11px] font-medium tracking-[0.12em] uppercase text-gray-800 hover:text-black transition-colors">Collections</a>
                    <a href="{{ route('products') }}" class="text-[11px] font-medium tracking-[0.12em] uppercase text-gray-800 hover:text-black transition-colors">New Arrivals</a>
                </div>

                <!-- Mobile Menu Button -->
                <button type="button" class="md:hidden p-2 text-gray-800" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>

                <!-- Logo -->
                <a href="/" class="absolute left-1/2 -translate-x-1/2 text-[22px] font-semibold tracking-[0.2em] uppercase text-gray-900">
                    PureFit Apparel
                </a>

                <!-- Log In -->
                @guest
                    <a href="{{ route('login') }}" class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-800 hover:text-black transition-colors">
                        Log In
                    </a>
                @else
                    <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : (auth()->user()->role === 'business' ? route('business.dashboard') : route('buyer.dashboard')) }}" class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-800 hover:text-black transition-colors">
                        Dashboard
                    </a>
                @endguest
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-[#f5f3ef] border-t border-[#e8e5e0]">
            <div class="px-6 py-4 space-y-3">
                <a href="{{ route('products') }}" class="block text-[11px] font-medium tracking-[0.12em] uppercase text-gray-800">Men</a>
                <a href="{{ route('products') }}" class="block text-[11px] font-medium tracking-[0.12em] uppercase text-gray-800">Women</a>
                <a href="{{ route('products') }}" class="block text-[11px] font-medium tracking-[0.12em] uppercase text-gray-800">Collections</a>
                <a href="{{ route('products') }}" class="block text-[11px] font-medium tracking-[0.12em] uppercase text-gray-800">New Arrivals</a>
            </div>
        </div>
    </nav>

    @yield('content')

</body>
</html>
