@extends('business.layout')

@section('title', 'Sales')
@section('nav-sales', 'bg-[#f5f3ef] text-gray-900')

@section('content')

    <!-- Header -->
    <div class="mb-8">
        <h1 class="font-serif-display text-[36px] text-gray-900 mb-2">Sales</h1>
        <p class="text-[14px] text-gray-600">View your sales history and earnings.</p>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-10">
        <div class="bg-white border border-[#e8e5e0] px-6 py-5">
            <p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Total Revenue</p>
            <p class="text-[28px] font-light text-gray-900">₱{{ number_format($totalRevenue, 2) }}</p>
        </div>
        <div class="bg-white border border-[#e8e5e0] px-6 py-5">
            <p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Commission Paid</p>
            <p class="text-[28px] font-light text-gray-900">₱{{ number_format($totalCommission, 2) }}</p>
        </div>
        <div class="bg-white border border-[#e8e5e0] px-6 py-5">
            <p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Net Earnings</p>
            <p class="text-[28px] font-light text-gray-900">₱{{ number_format($netEarnings, 2) }}</p>
        </div>
    </div>

    <!-- Sales History -->
    <div class="bg-white border border-[#e8e5e0]">
        <div class="px-6 py-4 border-b border-[#e8e5e0]">
            <h2 class="text-[13px] font-semibold tracking-[0.1em] uppercase text-gray-700">Completed Orders</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-[#e8e5e0] bg-[#faf9f7]">
                        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">Order ID</th>
                        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">Customer</th>
                        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">Type</th>
                        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">Total</th>
                        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">Commission</th>
                        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr class="border-b border-[#f0ede8] hover:bg-[#faf9f7] transition-colors">
                            <td class="px-6 py-4 text-[14px]">#{{ $order->id }}</td>
                            <td class="px-6 py-4 text-[14px]">{{ $order->buyer->name ?? '—' }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex px-2 py-0.5 text-[11px] font-semibold uppercase rounded-full {{ $order->type == 'retail' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">{{ $order->type }}</span>
                            </td>
                            <td class="px-6 py-4 text-[14px] font-medium">₱{{ number_format($order->total, 2) }}</td>
                            <td class="px-6 py-4 text-[14px] text-gray-600">₱{{ number_format($order->commission, 2) }}</td>
                            <td class="px-6 py-4 text-[13px] text-gray-500">{{ $order->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-[14px] text-gray-500">
                                No completed sales found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
