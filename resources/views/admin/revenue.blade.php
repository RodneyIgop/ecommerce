@extends('admin.layout')
@section('title', 'Commission & Revenue')
@section('nav-revenue', 'bg-[#f5f3ef] text-gray-900')
@section('content')
<div class="mb-8"><h1 class="font-serif-display text-[36px] text-gray-900 mb-2">Commission & Revenue</h1><p class="text-[14px] text-gray-600">Platform earnings and payout configuration.</p></div>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-white border border-[#e8e5e0] px-6 py-5"><p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Total Commission</p><p class="text-[28px] font-light text-gray-900">₱{{ number_format($totalCommission,2) }}</p></div>
    <div class="bg-white border border-[#e8e5e0] px-6 py-5"><p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Platform Fees</p><p class="text-[28px] font-light text-gray-900">₱{{ number_format($totalPlatformFees,2) }}</p></div>
    <div class="bg-white border border-[#e8e5e0] px-6 py-5"><p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Total Revenue</p><p class="text-[28px] font-light text-gray-900">₱{{ number_format($totalRevenue,2) }}</p></div>
    <div class="bg-white border border-[#e8e5e0] px-6 py-5"><p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Pending Payouts</p><p class="text-[28px] font-light text-gray-900">₱{{ number_format($pendingPayouts,2) }}</p></div>
</div>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
    <div class="bg-white border border-[#e8e5e0]">
        <div class="px-6 py-4 border-b border-[#e8e5e0]"><h2 class="text-[13px] font-semibold tracking-[0.1em] uppercase text-gray-700">Revenue Split</h2></div>
        <div class="p-6 space-y-4">
            <div class="flex justify-between"><span class="text-[14px] text-gray-600">Retail Orders</span><span class="text-[14px] font-medium text-gray-900">₱{{ number_format($retailRevenue,2) }}</span></div>
            <div class="flex justify-between"><span class="text-[14px] text-gray-600">B2B Orders</span><span class="text-[14px] font-medium text-gray-900">₱{{ number_format($b2bRevenue,2) }}</span></div>
        </div>
    </div>
    <div class="bg-white border border-[#e8e5e0]">
        <div class="px-6 py-4 border-b border-[#e8e5e0]"><h2 class="text-[13px] font-semibold tracking-[0.1em] uppercase text-gray-700">Configure Rates</h2></div>
        <form method="POST" action="{{ route('admin.revenue.update') }}" class="p-6 space-y-4">@csrf
            <div><label class="block text-[12px] font-semibold tracking-[0.1em] uppercase text-gray-500 mb-1.5">Commission Rate (%)</label>
                <input type="number" name="commission_rate" value="{{ $commissionRate }}" step="0.01" min="0" max="100" class="w-full border border-[#e8e5e0] rounded px-4 py-2.5 text-[14px] focus:outline-none focus:border-gray-400"></div>
            <div><label class="block text-[12px] font-semibold tracking-[0.1em] uppercase text-gray-500 mb-1.5">Platform Fee per Transaction (₱)</label>
                <input type="number" name="platform_fee" value="{{ $platformFee }}" step="0.01" min="0" class="w-full border border-[#e8e5e0] rounded px-4 py-2.5 text-[14px] focus:outline-none focus:border-gray-400"></div>
            <button type="submit" class="px-5 py-2.5 bg-[#111] text-white text-[12px] font-semibold tracking-[0.1em] uppercase rounded hover:bg-gray-800 transition-colors">Save Settings</button>
        </form>
    </div>
</div>
@endsection
