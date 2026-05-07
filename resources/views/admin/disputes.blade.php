@extends('admin.layout')
@section('title', 'Dispute / Refund Center')
@section('nav-disputes', 'bg-[#f5f3ef] text-gray-900')
@section('content')
<div class="mb-8"><h1 class="font-serif-display text-[36px] text-gray-900 mb-2">Dispute / Refund Center</h1><p class="text-[14px] text-gray-600">Manage customer disputes, refund requests, and business complaints.</p></div>
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
    <div class="bg-white border border-[#e8e5e0] px-6 py-5"><p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Total Cases</p><p class="text-[28px] font-light text-gray-900">{{ $disputes->count() }}</p></div>
    <div class="bg-white border border-[#e8e5e0] px-6 py-5"><p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Open</p><p class="text-[28px] font-light text-gray-900">{{ $openCount }}</p></div>
    <div class="bg-white border border-[#e8e5e0] px-6 py-5"><p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Resolved</p><p class="text-[28px] font-light text-gray-900">{{ $resolvedCount }}</p></div>
</div>
<div class="bg-white border border-[#e8e5e0]">
    <div class="px-6 py-4 border-b border-[#e8e5e0]"><h2 class="text-[13px] font-semibold tracking-[0.1em] uppercase text-gray-700">All Cases</h2></div>
    <div class="overflow-x-auto"><table class="w-full text-left"><thead><tr class="border-b border-[#e8e5e0] bg-[#faf9f7]">
        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">ID</th>
        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">Type</th>
        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">Order</th>
        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">User</th>
        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">Business</th>
        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">Status</th>
        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">Description</th>
        <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">Action</th>
    </tr></thead><tbody>
    @forelse($disputes as $d)
    <tr class="border-b border-[#f0ede8] hover:bg-[#faf9f7]">
        <td class="px-6 py-4 text-[14px]">#{{ $d->id }}</td>
        <td class="px-6 py-4 text-[14px]"><span class="inline-flex px-2 py-0.5 text-[11px] font-semibold uppercase rounded-full {{ $d->type=='refund'?'bg-orange-100 text-orange-800':($d->type=='complaint'?'bg-red-100 text-red-800':'bg-yellow-100 text-yellow-800') }}">{{ $d->type }}</span></td>
        <td class="px-6 py-4 text-[14px]">#{{ $d->order->id ?? '—' }}</td>
        <td class="px-6 py-4 text-[14px]">{{ $d->user->name ?? '—' }}</td>
        <td class="px-6 py-4 text-[14px]">{{ $d->business->name ?? '—' }}</td>
        <td class="px-6 py-4"><span class="inline-flex px-2 py-0.5 text-[11px] font-semibold uppercase rounded-full {{ $d->status=='open'?'bg-yellow-100 text-yellow-800':($d->status=='resolved'?'bg-green-100 text-green-800':'bg-gray-100 text-gray-800') }}">{{ $d->status }}</span></td>
        <td class="px-6 py-4 text-[14px] text-gray-600 max-w-xs truncate">{{ $d->description }}</td>
        <td class="px-6 py-4">
            <form method="POST" action="{{ route('admin.disputes.update', $d) }}" class="inline">@csrf @method('PATCH')
                <select name="status" onchange="this.form.submit()" class="text-[12px] border border-[#e8e5e0] rounded px-2 py-1 bg-white cursor-pointer">
                    <option value="open" {{ $d->status=='open'?'selected':'' }}>Open</option>
                    <option value="resolved" {{ $d->status=='resolved'?'selected':'' }}>Resolved</option>
                    <option value="closed" {{ $d->status=='closed'?'selected':'' }}>Closed</option>
                </select>
            </form>
        </td>
    </tr>
    @empty<tr><td colspan="8" class="px-6 py-10 text-center text-[14px] text-gray-500">No disputes or refund requests.</td></tr>@endforelse
    </tbody></table></div>
</div>
@endsection
