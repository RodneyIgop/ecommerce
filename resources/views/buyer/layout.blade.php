<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Account') — PureFit Apparel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .font-serif-display { font-family: 'Instrument Serif', serif; }
        .font-sans-body { font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; }
    </style>
</head>
<body class="font-sans-body text-gray-900 antialiased bg-[#f5f3ef] min-h-screen">

    <!-- Top Bar -->
    <nav class="bg-[#111] text-white fixed top-0 left-0 right-0 z-50">
        <div class="max-w-full mx-auto px-6">
            <div class="flex items-center justify-between h-[60px]">
                <div class="flex items-center gap-6">
                    <a href="/" class="text-[16px] font-semibold tracking-[0.2em] uppercase">
                        PureFit Apparel
                    </a>
                    <span class="text-[11px] font-medium tracking-[0.1em] uppercase text-gray-400 hidden sm:inline">My Account</span>
                </div>
                <div class="flex items-center gap-5">
                    <span class="text-[13px] text-gray-300 hidden sm:inline">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-400 hover:text-white transition-colors bg-transparent border-none cursor-pointer">
                            Log Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex pt-[60px] min-h-screen">
        <!-- Sidebar -->
        <aside class="w-[260px] bg-white border-r border-[#e8e5e0] fixed top-[60px] bottom-0 left-0 overflow-y-auto z-40 hidden md:block">
            <div class="px-5 py-6">
                <p class="text-[10px] font-bold tracking-[0.15em] uppercase text-gray-400 mb-4 px-3">My Account</p>

                <nav class="space-y-1">
                    <a href="{{ route('buyer.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 text-[13px] font-medium text-gray-800 rounded hover:bg-[#f5f3ef] transition-colors @yield('nav-overview', '')">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z"/></svg>
                        Dashboard
                    </a>
                    <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-[13px] font-medium text-gray-500 rounded hover:bg-[#f5f3ef] hover:text-gray-800 transition-colors">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/></svg>
                        Shopping
                    </a>
                    <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-[13px] font-medium text-gray-500 rounded hover:bg-[#f5f3ef] hover:text-gray-800 transition-colors">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0H6m15 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h-.008M8.25 12a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h-.008m6.75-7.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h-.008M12.75 12a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h-.008m-1.125-7.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h-.008"/></svg>
                        Orders
                    </a>
                    <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-[13px] font-medium text-gray-500 rounded hover:bg-[#f5f3ef] hover:text-gray-800 transition-colors">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/></svg>
                        Wishlist
                    </a>
                    <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-[13px] font-medium text-gray-500 rounded hover:bg-[#f5f3ef] hover:text-gray-800 transition-colors">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z"/></svg>
                        Payments
                    </a>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 md:ml-[260px] p-6 lg:p-10">
            @yield('content')
        </main>
    </div>

</body>
</html>
