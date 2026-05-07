@extends('admin.layout')

@section('title', 'Platform Overview')
@section('nav-overview', 'bg-[#f5f3ef] text-gray-900')

@section('content')

    <!-- Header -->
    <div class="mb-8">
        <h1 class="font-serif-display text-[36px] text-gray-900 mb-2">Platform Overview</h1>
        <p class="text-[14px] text-gray-600">This is your control center.</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
        <div class="bg-white border border-[#e8e5e0] px-6 py-5">
            <p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Total Users</p>
            <p class="text-[28px] font-light text-gray-900">{{ $totalUsers }}</p>
        </div>
        <div class="bg-white border border-[#e8e5e0] px-6 py-5">
            <p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Businesses</p>
            <p class="text-[28px] font-light text-gray-900">{{ $totalBusinesses }}</p>
        </div>
        <div class="bg-white border border-[#e8e5e0] px-6 py-5">
            <p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Solo Buyers</p>
            <p class="text-[28px] font-light text-gray-900">{{ $totalBuyers }}</p>
        </div>
        <div class="bg-white border border-[#e8e5e0] px-6 py-5">
            <p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Products Listed</p>
            <p class="text-[28px] font-light text-gray-900">{{ $totalProducts }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-10">
        <div class="bg-white border border-[#e8e5e0] px-6 py-5">
            <p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Retail Orders</p>
            <p class="text-[28px] font-light text-gray-900">{{ $retailOrders }}</p>
        </div>
        <div class="bg-white border border-[#e8e5e0] px-6 py-5">
            <p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">B2B Orders</p>
            <p class="text-[28px] font-light text-gray-900">{{ $b2bOrders }}</p>
        </div>
        <div class="bg-white border border-[#e8e5e0] px-6 py-5">
            <p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Revenue</p>
            <p class="text-[28px] font-light text-gray-900">₱{{ number_format($totalRevenue, 2) }}</p>
        </div>
    </div>

    <!-- Accounts Table -->
    <div class="bg-white border border-[#e8e5e0] mb-10">
        <div class="px-6 py-4 border-b border-[#e8e5e0] flex items-center justify-between">
            <h2 class="text-[13px] font-semibold tracking-[0.1em] uppercase text-gray-700">All Accounts</h2>
            <span class="text-[11px] text-gray-500">Business + Solo Buyers</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-[#e8e5e0] bg-[#faf9f7]">
                        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">Name</th>
                        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">Email</th>
                        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">Role</th>
                        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">Registered</th>
                        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr class="border-b border-[#f0ede8] hover:bg-[#faf9f7] transition-colors">
                            <td class="px-6 py-4 text-[14px] text-gray-900 font-medium">{{ $user->name }}</td>
                            <td class="px-6 py-4 text-[14px] text-gray-600">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 text-[11px] font-semibold tracking-wider uppercase rounded-full
                                    {{ $user->role === 'business' ? 'bg-[#e8e5e0] text-gray-800' : 'bg-[#f0ede8] text-gray-700' }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-[13px] text-gray-500">{{ $user->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1.5 text-[12px] text-green-700 font-medium">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                    Active
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-[14px] text-gray-500">
                                No accounts found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Section Previews -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
        <!-- Commission & Revenue Preview -->
        <div class="bg-white border border-[#e8e5e0]">
            <div class="px-6 py-4 border-b border-[#e8e5e0]">
                <h2 class="text-[13px] font-semibold tracking-[0.1em] uppercase text-gray-700">Commission & Revenue</h2>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-[14px] text-gray-600">Commission per sale</span>
                    <span class="text-[14px] font-medium text-gray-900">{{ \App\Models\Setting::get('commission_rate', '10') }}%</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-[14px] text-gray-600">Platform fees / transaction</span>
                    <span class="text-[14px] font-medium text-gray-900">₱{{ number_format((float)\App\Models\Setting::get('platform_fee', '2.50'), 2) }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-[14px] text-gray-600">Pending payouts</span>
                    <span class="text-[14px] font-medium text-gray-900">₱{{ number_format(\App\Models\Order::where('status', '!=', 'cancelled')->sum('total') - \App\Models\Order::sum('commission') - \App\Models\Order::sum('platform_fee'), 2) }}</span>
                </div>
                <div class="pt-2">
                    <a href="{{ route('admin.revenue') }}" class="inline-flex text-[12px] font-semibold tracking-[0.1em] uppercase text-gray-800 hover:text-black transition-colors underline underline-offset-4">Configure rates</a>
                </div>
            </div>
        </div>

        <!-- Dispute Center Preview -->
        <div class="bg-white border border-[#e8e5e0]">
            <div class="px-6 py-4 border-b border-[#e8e5e0]">
                <h2 class="text-[13px] font-semibold tracking-[0.1em] uppercase text-gray-700">Dispute / Refund Center</h2>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-[14px] text-gray-600">Open disputes</span>
                    <span class="text-[14px] font-medium text-gray-900">{{ \App\Models\Dispute::where('status', 'open')->count() }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-[14px] text-gray-600">Refund requests</span>
                    <span class="text-[14px] font-medium text-gray-900">{{ \App\Models\Dispute::where('type', 'refund')->count() }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-[14px] text-gray-600">Business disputes</span>
                    <span class="text-[14px] font-medium text-gray-900">{{ \App\Models\Dispute::where('type', 'dispute')->count() }}</span>
                </div>
                <div class="pt-2">
                    <a href="{{ route('admin.disputes') }}" class="inline-flex text-[12px] font-semibold tracking-[0.1em] uppercase text-gray-800 hover:text-black transition-colors underline underline-offset-4">View all cases</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Verification & Settings Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10">
        <!-- Verification -->
        <div class="bg-white border border-[#e8e5e0]">
            <div class="px-6 py-4 border-b border-[#e8e5e0]">
                <h2 class="text-[13px] font-semibold tracking-[0.1em] uppercase text-gray-700">Verification System</h2>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-[14px] text-gray-600">Pending approvals</span>
                    <span class="text-[14px] font-medium text-gray-900">{{ $pendingVerifications }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-[14px] text-gray-600">Verified businesses</span>
                    <span class="text-[14px] font-medium text-gray-900">{{ \App\Models\BusinessProfile::whereNotNull('verified_at')->count() }}</span>
                </div>
                <div class="pt-2">
                    <a href="{{ route('admin.verifications') }}" class="inline-flex text-[12px] font-semibold tracking-[0.1em] uppercase text-gray-800 hover:text-black transition-colors underline underline-offset-4">Manage verifications</a>
                </div>
            </div>
        </div>

        <!-- Order Split -->
        <div class="bg-white border border-[#e8e5e0]">
            <div class="px-6 py-4 border-b border-[#e8e5e0]">
                <h2 class="text-[13px] font-semibold tracking-[0.1em] uppercase text-gray-700">Order System</h2>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-[14px] text-gray-600">Retail (1–3 pcs)</span>
                    <span class="text-[14px] font-medium text-gray-900">{{ \App\Models\Order::where('type', 'retail')->count() }} orders</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-[14px] text-gray-600">B2B (bulk)</span>
                    <span class="text-[14px] font-medium text-gray-900">{{ \App\Models\Order::where('type', 'b2b')->count() }} orders</span>
                </div>
                <div class="pt-2">
                    <a href="{{ route('admin.orders') }}" class="inline-flex text-[12px] font-semibold tracking-[0.1em] uppercase text-gray-800 hover:text-black transition-colors underline underline-offset-4">View orders</a>
                </div>
            </div>
        </div>

        <!-- System Settings -->
        <div class="bg-white border border-[#e8e5e0]">
            <div class="px-6 py-4 border-b border-[#e8e5e0]">
                <h2 class="text-[13px] font-semibold tracking-[0.1em] uppercase text-gray-700">System Settings</h2>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-[14px] text-gray-600">Commission rate</span>
                    <span class="text-[14px] font-medium text-gray-900">{{ \App\Models\Setting::get('commission_rate', '10') }}%</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-[14px] text-gray-600">Solo buyer max</span>
                    <span class="text-[14px] font-medium text-gray-900">{{ \App\Models\Setting::get('solo_buyer_max', '3') }} pieces</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-[14px] text-gray-600">Free shipping threshold</span>
                    <span class="text-[14px] font-medium text-gray-900">₱{{ \App\Models\Setting::get('free_shipping_threshold', '75') }}</span>
                </div>
                <div class="pt-2">
                    <a href="{{ route('admin.settings') }}" class="inline-flex text-[12px] font-semibold tracking-[0.1em] uppercase text-gray-800 hover:text-black transition-colors underline underline-offset-4">Edit settings</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Analytics Teaser -->
    <div class="bg-white border border-[#e8e5e0] mb-10">
        <div class="px-6 py-4 border-b border-[#e8e5e0] flex items-center justify-between">
            <h2 class="text-[13px] font-semibold tracking-[0.1em] uppercase text-gray-700">Analytics Dashboard</h2>
            <a href="{{ route('admin.analytics') }}" class="text-[12px] font-semibold tracking-[0.1em] uppercase text-gray-800 hover:text-black transition-colors underline underline-offset-4">View full analytics</a>
        </div>
        <div class="p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Top-selling business</p>
                <p class="text-[16px] text-gray-900">{{ \App\Models\User::where('role', \App\Models\User::ROLE_BUSINESS)->withCount('ordersAsBusiness')->orderBy('orders_as_business_count', 'desc')->first()->name ?? '—' }}</p>
            </div>
            <div>
                <p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Top product</p>
                <p class="text-[16px] text-gray-900">{{ \App\Models\Product::withCount('orderItems')->orderBy('order_items_count', 'desc')->first()->name ?? '—' }}</p>
            </div>
            <div>
                <p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Most active buyer</p>
                <p class="text-[16px] text-gray-900">{{ \App\Models\User::where('role', \App\Models\User::ROLE_BUYER)->withCount('ordersAsBuyer')->orderBy('orders_as_buyer_count', 'desc')->first()->name ?? '—' }}</p>
            </div>
            <div>
                <p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Conversion rate</p>
                <p class="text-[16px] text-gray-900">{{ \App\Models\User::whereIn('role', [\App\Models\User::ROLE_BUSINESS, \App\Models\User::ROLE_BUYER])->count() > 0 ? round((\App\Models\Order::count() / \App\Models\User::whereIn('role', [\App\Models\User::ROLE_BUSINESS, \App\Models\User::ROLE_BUYER])->count()) * 100, 1) : 0 }}%</p>
            </div>
        </div>
    </div>

@endsection
