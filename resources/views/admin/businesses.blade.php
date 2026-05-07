@extends('admin.layout')
@section('title', 'Business Management')
@section('nav-business', 'bg-[#f5f3ef] text-gray-900')
@section('content')
<div class="mb-8"><h1 class="font-serif-display text-[36px] text-gray-900 mb-2">Business Management</h1><p class="text-[14px] text-gray-600">Manage all registered businesses.</p></div>
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
    <div class="bg-white border border-[#e8e5e0] px-6 py-5"><p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Total</p><p class="text-[28px] font-light text-gray-900">{{ $businesses->count() }}</p></div>
    <div class="bg-white border border-[#e8e5e0] px-6 py-5"><p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Active</p><p class="text-[28px] font-light text-gray-900">{{ $businesses->where('status','active')->count() }}</p></div>
    <div class="bg-white border border-[#e8e5e0] px-6 py-5"><p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Suspended</p><p class="text-[28px] font-light text-gray-900">{{ $businesses->where('status','suspended')->count() }}</p></div>
</div>
<div class="bg-white border border-[#e8e5e0]">
    <div class="px-6 py-4 border-b border-[#e8e5e0]"><h2 class="text-[13px] font-semibold tracking-[0.1em] uppercase text-gray-700">All Businesses</h2></div>
    <div class="overflow-x-auto">
        <table class="w-full text-left"><thead><tr class="border-b border-[#e8e5e0] bg-[#faf9f7]">
            <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">Name</th>
            <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">Email</th>
            <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">Business</th>
            <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">Status</th>
            <th class="px-6 py-3.5 text-[11px] font-semibold tracking-[0.1em] uppercase text-gray-500">Action</th>
        </tr></thead><tbody>
        @forelse($businesses as $b)
        <tr class="border-b border-[#f0ede8] hover:bg-[#faf9f7]">
            <td class="px-6 py-4 text-[14px] font-medium">{{ $b->name }}</td>
            <td class="px-6 py-4 text-[14px] text-gray-600">{{ $b->email }}</td>
            <td class="px-6 py-4 text-[14px] text-gray-600">{{ $b->businessProfile->business_name ?? '—' }}</td>
            <td class="px-6 py-4"><span class="inline-flex gap-1.5 text-[12px] font-medium {{ $b->status=='active'?'text-green-700':'text-red-600' }}"><span class="w-1.5 h-1.5 rounded-full {{ $b->status=='active'?'bg-green-500':'bg-red-500' }}"></span>{{ ucfirst($b->status) }}</span></td>
            <td class="px-6 py-4">
                <form method="POST" action="{{ route('admin.users.status', $b) }}" class="inline">@csrf @method('PATCH')
                    <input type="hidden" name="status" value="{{ $b->status=='active'?'suspended':'active' }}">
                    <button type="submit" class="text-[12px] font-semibold tracking-[0.1em] uppercase {{ $b->status=='active'?'text-red-600 hover:text-red-800':'text-green-700 hover:text-green-900' }} underline underline-offset-2">{{ $b->status=='active'?'Suspend':'Activate' }}</button>
                </form>
            </td>
        </tr>
        @empty<tr><td colspan="5" class="px-6 py-10 text-center text-[14px] text-gray-500">No businesses found.</td></tr>@endforelse
        </tbody></table>
    </div>
</div>
@endsection
