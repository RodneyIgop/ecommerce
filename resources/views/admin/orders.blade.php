@extends('admin.layout')
@section('title', 'Order System')
@section('nav-orders', 'bg-[#f5f3ef] text-gray-900')
@section('content')
<div class="mb-8"><h1 class="font-serif-display text-[36px] text-gray-900 mb-2">Order System</h1><p class="text-[14px] text-gray-600">Retail and B2B orders split view.</p></div>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-white border border-[#e8e5e0] px-6 py-5"><p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Retail Orders</p><p class="text-[28px] font-light text-gray-900">{{ $retailOrders->count() }}</p></div>
    <div class="bg-white border border-[#e8e5e0] px-6 py-5"><p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">B2B Orders</p><p class="text-[28px] font-light text-gray-900">{{ $b2bOrders->count() }}</p></div>
    <div class="bg-white border border-[#e8e5e0] px-6 py-5"><p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Processing</p><p class="text-[28px] font-light text-gray-900">{{ $retailOrders->where('status','processing')->count()+$b2bOrders->where('status','processing')->count() }}</p></div>
    <div class="bg-white border border-[#e8e5e0] px-6 py-5"><p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Pending</p><p class="text-[28px] font-light text-gray-900">{{ $retailOrders->where('status','pending')->count()+$b2bOrders->where('status','pending')->count() }}</p></div>
</div>
<div class="bg-white border border-[#e8e5e0] mb-6">
    <div class="px-6 py-4 border-b border-[#e8e5e0]"><h2 class="text-[13px] font-semibold tracking-[0.1em] uppercase text-gray-700">Retail Orders (1–3 pcs)</h2></div>
    <div class="overflow-x-auto"><table class="w-full text-left"><thead><tr class="border-b border-[#e8e5e0] bg-[#faf9f7]">
        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">ID</th>
        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">Buyer</th>
        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">Business</th>
        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">Total</th>
        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">Status</th>
        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">Date</th>
        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">Action</th>
    </tr></thead><tbody>
    @forelse($retailOrders as $o)
    <tr class="border-b border-[#f0ede8] hover:bg-[#faf9f7]">
        <td class="px-6 py-4 text-[14px]">#{{ $o->id }}</td>
        <td class="px-6 py-4 text-[14px]">{{ $o->buyer->name ?? '—' }}</td>
        <td class="px-6 py-4 text-[14px]">{{ $o->business->name ?? '—' }}</td>
        <td class="px-6 py-4 text-[14px] font-medium">₱{{ number_format($o->total,2) }}</td>
        <td class="px-6 py-4"><span class="inline-flex px-2 py-0.5 text-[11px] font-semibold uppercase rounded-full {{ $o->status=='pending'?'bg-yellow-100 text-yellow-800':($o->status=='processing'?'bg-blue-100 text-blue-800':($o->status=='shipped'?'bg-purple-100 text-purple-800':($o->status=='delivered'?'bg-green-100 text-green-800':'bg-gray-100 text-gray-800'))) }}">{{ $o->status }}</span></td>
        <td class="px-6 py-4 text-[13px] text-gray-500">{{ $o->created_at->format('M d, Y') }}</td>
        <td class="px-6 py-4">
            <form method="POST" action="{{ route('admin.orders.status', $o) }}" class="inline">@csrf @method('PATCH')
                <select name="status" onchange="this.form.submit()" class="text-[12px] border border-[#e8e5e0] rounded px-2 py-1 bg-white cursor-pointer">
                    <option value="pending" {{ $o->status=='pending'?'selected':'' }}>Pending</option>
                    <option value="processing" {{ $o->status=='processing'?'selected':'' }}>Processing</option>
                    <option value="shipped" {{ $o->status=='shipped'?'selected':'' }}>Shipped</option>
                    <option value="delivered" {{ $o->status=='delivered'?'selected':'' }}>Delivered</option>
                    <option value="cancelled" {{ $o->status=='cancelled'?'selected':'' }}>Cancelled</option>
                </select>
            </form>
        </td>
    </tr>
    @empty<tr><td colspan="7" class="px-6 py-10 text-center text-[14px] text-gray-500">No retail orders.</td></tr>@endforelse
    </tbody></table></div>
</div>
<div class="bg-white border border-[#e8e5e0]">
    <div class="px-6 py-4 border-b border-[#e8e5e0]"><h2 class="text-[13px] font-semibold tracking-[0.1em] uppercase text-gray-700">B2B Bulk Orders</h2></div>
    <div class="overflow-x-auto"><table class="w-full text-left"><thead><tr class="border-b border-[#e8e5e0] bg-[#faf9f7]">
        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">ID</th>
        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">Buyer</th>
        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">Business</th>
        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">Total</th>
        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">Status</th>
        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">Date</th>
        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">Action</th>
    </tr></thead><tbody>
    @forelse($b2bOrders as $o)
    <tr class="border-b border-[#f0ede8] hover:bg-[#faf9f7]">
        <td class="px-6 py-4 text-[14px]">#{{ $o->id }}</td>
        <td class="px-6 py-4 text-[14px]">{{ $o->buyer->name ?? '—' }}</td>
        <td class="px-6 py-4 text-[14px]">{{ $o->business->name ?? '—' }}</td>
        <td class="px-6 py-4 text-[14px] font-medium">₱{{ number_format($o->total,2) }}</td>
        <td class="px-6 py-4"><span class="inline-flex px-2 py-0.5 text-[11px] font-semibold uppercase rounded-full {{ $o->status=='pending'?'bg-yellow-100 text-yellow-800':($o->status=='processing'?'bg-blue-100 text-blue-800':($o->status=='shipped'?'bg-purple-100 text-purple-800':($o->status=='delivered'?'bg-green-100 text-green-800':'bg-gray-100 text-gray-800'))) }}">{{ $o->status }}</span></td>
        <td class="px-6 py-4 text-[13px] text-gray-500">{{ $o->created_at->format('M d, Y') }}</td>
        <td class="px-6 py-4">
            <form method="POST" action="{{ route('admin.orders.status', $o) }}" class="inline">@csrf @method('PATCH')
                <select name="status" onchange="this.form.submit()" class="text-[12px] border border-[#e8e5e0] rounded px-2 py-1 bg-white cursor-pointer">
                    <option value="pending" {{ $o->status=='pending'?'selected':'' }}>Pending</option>
                    <option value="processing" {{ $o->status=='processing'?'selected':'' }}>Processing</option>
                    <option value="shipped" {{ $o->status=='shipped'?'selected':'' }}>Shipped</option>
                    <option value="delivered" {{ $o->status=='delivered'?'selected':'' }}>Delivered</option>
                    <option value="cancelled" {{ $o->status=='cancelled'?'selected':'' }}>Cancelled</option>
                </select>
            </form>
        </td>
    </tr>
    @empty<tr><td colspan="7" class="px-6 py-10 text-center text-[14px] text-gray-500">No B2B orders.</td></tr>@endforelse
    </tbody></table></div>
</div>
@endsection
