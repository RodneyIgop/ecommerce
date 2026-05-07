@extends('admin.layout')
@section('title', 'System Settings')
@section('nav-settings', 'bg-[#f5f3ef] text-gray-900')
@section('content')
<div class="mb-8"><h1 class="font-serif-display text-[36px] text-gray-900 mb-2">System Settings</h1><p class="text-[14px] text-gray-600">Configure platform-wide rules and limits.</p></div>
<div class="bg-white border border-[#e8e5e0] max-w-2xl">
    <div class="px-6 py-4 border-b border-[#e8e5e0]"><h2 class="text-[13px] font-semibold tracking-[0.1em] uppercase text-gray-700">Platform Configuration</h2></div>
    <form method="POST" action="{{ route('admin.settings.update') }}" class="p-6 space-y-5">@csrf
        <div><label class="block text-[12px] font-semibold tracking-[0.1em] uppercase text-gray-500 mb-1.5">Commission Rate (%)</label>
            <input type="number" name="commission_rate" value="{{ $settings['commission_rate'] }}" step="0.01" min="0" max="100" class="w-full border border-[#e8e5e0] rounded px-4 py-2.5 text-[14px] focus:outline-none focus:border-gray-400"></div>
        <div><label class="block text-[12px] font-semibold tracking-[0.1em] uppercase text-gray-500 mb-1.5">Platform Fee per Transaction (₱)</label>
            <input type="number" name="platform_fee" value="{{ $settings['platform_fee'] }}" step="0.01" min="0" class="w-full border border-[#e8e5e0] rounded px-4 py-2.5 text-[14px] focus:outline-none focus:border-gray-400"></div>
        <div><label class="block text-[12px] font-semibold tracking-[0.1em] uppercase text-gray-500 mb-1.5">Solo Buyer Max Pieces</label>
            <input type="number" name="solo_buyer_max" value="{{ $settings['solo_buyer_max'] }}" min="1" class="w-full border border-[#e8e5e0] rounded px-4 py-2.5 text-[14px] focus:outline-none focus:border-gray-400"></div>
        <div><label class="block text-[12px] font-semibold tracking-[0.1em] uppercase text-gray-500 mb-1.5">Free Shipping Threshold (₱)</label>
            <input type="number" name="free_shipping_threshold" value="{{ $settings['free_shipping_threshold'] }}" step="0.01" min="0" class="w-full border border-[#e8e5e0] rounded px-4 py-2.5 text-[14px] focus:outline-none focus:border-gray-400"></div>
        <div><label class="block text-[12px] font-semibold tracking-[0.1em] uppercase text-gray-500 mb-1.5">Currency</label>
            <input type="text" name="currency" value="{{ $settings['currency'] }}" maxlength="5" class="w-full border border-[#e8e5e0] rounded px-4 py-2.5 text-[14px] focus:outline-none focus:border-gray-400"></div>
        <button type="submit" class="px-6 py-2.5 bg-[#111] text-white text-[12px] font-semibold tracking-[0.1em] uppercase rounded hover:bg-gray-800 transition-colors">Save Settings</button>
    </form>
</div>
@endsection
