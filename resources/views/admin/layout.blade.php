<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') — PureFit Apparel</title>
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
                    <span class="text-[11px] font-medium tracking-[0.1em] uppercase text-gray-400 hidden sm:inline">Admin Panel</span>
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
                <p class="text-[10px] font-bold tracking-[0.15em] uppercase text-gray-400 mb-4 px-3">Control Center</p>

                <nav class="space-y-1">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 text-[13px] font-medium text-gray-800 rounded hover:bg-[#f5f3ef] transition-colors @yield('nav-overview', '')">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z"/></svg>
                        Platform Overview
                    </a>
                    <a href="{{ route('admin.businesses') }}" class="flex items-center gap-3 px-3 py-2.5 text-[13px] font-medium text-gray-500 rounded hover:bg-[#f5f3ef] hover:text-gray-800 transition-colors @yield('nav-business', '')">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/></svg>
                        Business Management
                    </a>
                    <a href="{{ route('admin.products') }}" class="flex items-center gap-3 px-3 py-2.5 text-[13px] font-medium text-gray-500 rounded hover:bg-[#f5f3ef] hover:text-gray-800 transition-colors @yield('nav-products', '')">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/></svg>
                        Product Oversight
                    </a>
                    <a href="{{ route('admin.revenue') }}" class="flex items-center gap-3 px-3 py-2.5 text-[13px] font-medium text-gray-500 rounded hover:bg-[#f5f3ef] hover:text-gray-800 transition-colors @yield('nav-revenue', '')">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                        Commission & Revenue
                    </a>
                    <a href="{{ route('admin.orders') }}" class="flex items-center gap-3 px-3 py-2.5 text-[13px] font-medium text-gray-500 rounded hover:bg-[#f5f3ef] hover:text-gray-800 transition-colors @yield('nav-orders', '')">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0H6m15 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h-.008M8.25 12a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h-.008m6.75-7.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h-.008M12.75 12a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h-.008m-1.125-7.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h-.008"/></svg>
                        Order System
                    </a>
                    <a href="{{ route('admin.disputes') }}" class="flex items-center gap-3 px-3 py-2.5 text-[13px] font-medium text-gray-500 rounded hover:bg-[#f5f3ef] hover:text-gray-800 transition-colors @yield('nav-disputes', '')">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z"/></svg>
                        Dispute / Refund Center
                    </a>
                    <a href="{{ route('admin.users') }}" class="flex items-center gap-3 px-3 py-2.5 text-[13px] font-medium text-gray-500 rounded hover:bg-[#f5f3ef] hover:text-gray-800 transition-colors @yield('nav-users', '')">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/></svg>
                        User Management
                    </a>
                    <a href="{{ route('admin.analytics') }}" class="flex items-center gap-3 px-3 py-2.5 text-[13px] font-medium text-gray-500 rounded hover:bg-[#f5f3ef] hover:text-gray-800 transition-colors @yield('nav-analytics', '')">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z"/></svg>
                        Analytics Dashboard
                    </a>
                    <a href="{{ route('admin.verifications') }}" class="flex items-center gap-3 px-3 py-2.5 text-[13px] font-medium text-gray-500 rounded hover:bg-[#f5f3ef] hover:text-gray-800 transition-colors @yield('nav-verifications', '')">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z"/></svg>
                        Verification System
                    </a>
                    <a href="{{ route('admin.reviews') }}" class="flex items-center gap-3 px-3 py-2.5 text-[13px] font-medium text-gray-500 rounded hover:bg-[#f5f3ef] hover:text-gray-800 transition-colors @yield('nav-reviews', '')">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z"/></svg>
                        Reviews
                    </a>
                    <a href="{{ route('admin.transactions') }}" class="flex items-center gap-3 px-3 py-2.5 text-[13px] font-medium text-gray-500 rounded hover:bg-[#f5f3ef] hover:text-gray-800 transition-colors @yield('nav-transactions', '')">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></svg>
                        Transaction Logs
                    </a>
                    <a href="{{ route('admin.settings') }}" class="flex items-center gap-3 px-3 py-2.5 text-[13px] font-medium text-gray-500 rounded hover:bg-[#f5f3ef] hover:text-gray-800 transition-colors @yield('nav-settings', '')">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.352c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.431.992a6.759 6.759 0 0 1 0 .255c-.007.378.138.75.43.991l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 0 1-.22.128c-.331.183-.581.495-.644.87l-.212 1.281c-.09.543-.56.94-1.11.94h-2.352c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.375-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 0 1 0-.255c.007-.378-.138-.75-.43-.991l-1.004-.828a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.75.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.87l.213-1.281Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                        System Settings
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
