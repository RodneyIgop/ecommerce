@extends('business.layout')

@section('title', 'Orders')
@section('nav-orders', 'bg-[#f5f3ef] text-gray-900')

@section('content')

    <!-- Header -->
    <div class="mb-8">
        <h1 class="font-serif-display text-[36px] text-gray-900 mb-2">Orders</h1>
        <p class="text-[14px] text-gray-600">Manage incoming orders and shipments.</p>
    </div>

    <!-- Retail Orders -->
    <div class="bg-white border border-[#e8e5e0] mb-10">
        <div class="px-6 py-4 border-b border-[#e8e5e0]">
            <h2 class="text-[13px] font-semibold tracking-[0.1em] uppercase text-gray-700">Retail Orders</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-[#e8e5e0] bg-[#faf9f7]">
                        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">Order ID</th>
                        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">Customer</th>
                        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">Total</th>
                        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">Status</th>
                        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">Date</th>
                        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($retailOrders as $order)
                        <tr class="border-b border-[#f0ede8] hover:bg-[#faf9f7] transition-colors">
                            <td class="px-6 py-4 text-[14px]">#{{ $order->id }}</td>
                            <td class="px-6 py-4 text-[14px]">{{ $order->buyer->name ?? '—' }}</td>
                            <td class="px-6 py-4 text-[14px] font-medium">₱{{ number_format($order->total, 2) }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex px-2 py-0.5 text-[11px] font-semibold uppercase rounded-full {{ $order->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : ($order->status == 'processing' ? 'bg-blue-100 text-blue-800' : ($order->status == 'shipped' ? 'bg-purple-100 text-purple-800' : ($order->status == 'delivered' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'))) }}">{{ $order->status }}</span>
                            </td>
                            <td class="px-6 py-4 text-[13px] text-gray-500">{{ $order->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4">
                                <form method="POST" action="{{ route('business.orders.status', $order) }}" class="inline">@csrf @method('PATCH')
                                    <select name="status" onchange="this.form.submit()" class="text-[12px] border border-[#e8e5e0] rounded px-2 py-1 bg-white cursor-pointer">
                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-[14px] text-gray-500">
                                No retail orders found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- B2B Orders -->
    <div class="bg-white border border-[#e8e5e0]">
        <div class="px-6 py-4 border-b border-[#e8e5e0]">
            <h2 class="text-[13px] font-semibold tracking-[0.1em] uppercase text-gray-700">B2B Orders</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-[#e8e5e0] bg-[#faf9f7]">
                        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">Order ID</th>
                        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">Customer</th>
                        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">Total</th>
                        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">Status</th>
                        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">Date</th>
                        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($b2bOrders as $order)
                        <tr class="border-b border-[#f0ede8] hover:bg-[#faf9f7] transition-colors">
                            <td class="px-6 py-4 text-[14px]">#{{ $order->id }}</td>
                            <td class="px-6 py-4 text-[14px]">{{ $order->buyer->name ?? '—' }}</td>
                            <td class="px-6 py-4 text-[14px] font-medium">₱{{ number_format($order->total, 2) }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex px-2 py-0.5 text-[11px] font-semibold uppercase rounded-full {{ $order->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : ($order->status == 'processing' ? 'bg-blue-100 text-blue-800' : ($order->status == 'shipped' ? 'bg-purple-100 text-purple-800' : ($order->status == 'delivered' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'))) }}">{{ $order->status }}</span>
                            </td>
                            <td class="px-6 py-4 text-[13px] text-gray-500">{{ $order->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4">
                                <form method="POST" action="{{ route('business.orders.status', $order) }}" class="inline">@csrf @method('PATCH')
                                    <select name="status" onchange="this.form.submit()" class="text-[12px] border border-[#e8e5e0] rounded px-2 py-1 bg-white cursor-pointer">
                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-[14px] text-gray-500">
                                No B2B orders found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
