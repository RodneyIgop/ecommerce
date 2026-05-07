@extends('admin.layout')
@section('title', 'Verification System')
@section('nav-verifications', 'bg-[#f5f3ef] text-gray-900')
@section('content')
<div class="mb-8"><h1 class="font-serif-display text-[36px] text-gray-900 mb-2">Verification System</h1><p class="text-[14px] text-gray-600">Review and approve business account verifications.</p></div>
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
    <div class="bg-white border border-[#e8e5e0] px-6 py-5"><p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Total Profiles</p><p class="text-[28px] font-light text-gray-900">{{ $profiles->count() }}</p></div>
    <div class="bg-white border border-[#e8e5e0] px-6 py-5"><p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Verified</p><p class="text-[28px] font-light text-gray-900">{{ $profiles->whereNotNull('verified_at')->count() }}</p></div>
    <div class="bg-white border border-[#e8e5e0] px-6 py-5"><p class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-500 mb-1">Pending</p><p class="text-[28px] font-light text-gray-900">{{ $profiles->whereNull('verified_at')->count() }}</p></div>
</div>
<div class="bg-white border border-[#e8e5e0]">
    <div class="px-6 py-4 border-b border-[#e8e5e0]"><h2 class="text-[13px] font-semibold tracking-[0.1em] uppercase text-gray-700">Business Profiles</h2></div>
    <div class="overflow-x-auto"><table class="w-full text-left"><thead><tr class="border-b border-[#e8e5e0] bg-[#faf9f7]">
        <th class="px-6 py-3.5 text-[11px] font-semibold uppercase text-gray-500">Business</th>
        <th class="px-6 py-3.5 text-[11px] font-semibold uppercase text-gray-500">Owner</th>
        <th class="px-6 py-3.5 text-[11px] font-semibold uppercase text-gray-500">Phone</th>
        <th class="px-6 py-3.5 text-[11px] font-semibold uppercase text-gray-500">Status</th>
        <th class="px-6 py-3.5 text-[11px] font-semibold uppercase text-gray-500">Actions</th>
    </tr></thead><tbody>
    @forelse($profiles as $p)
    <tr class="border-b border-[#f0ede8] hover:bg-[#faf9f7]">
        <td class="px-6 py-4 text-[14px] font-medium">{{ $p->business_name }}</td>
        <td class="px-6 py-4 text-[14px] text-gray-600">{{ $p->user->name ?? '—' }}</td>
        <td class="px-6 py-4 text-[14px] text-gray-600">{{ $p->business_phone ?? '—' }}</td>
        <td class="px-6 py-4"><span class="inline-flex gap-1.5 text-[12px] font-medium {{ $p->verified_at?'text-green-700':'text-yellow-700' }}"><span class="w-1.5 h-1.5 rounded-full {{ $p->verified_at?'bg-green-500':'bg-yellow-500' }}"></span>{{ $p->verified_at ? 'Verified' : 'Pending' }}</span></td>
        <td class="px-6 py-4">
            <form method="POST" action="{{ route('admin.verifications.update', $p) }}" class="inline">@csrf @method('PATCH')
                @if(!$p->verified_at)
                    <button type="submit" name="action" value="verify" class="text-[12px] font-semibold uppercase text-green-700 hover:text-green-900 underline underline-offset-2">Verify</button>
                @else
                    <span class="text-[12px] text-gray-400">Verified</span>
                @endif
            </form>
        </td>
    </tr>
    @empty<tr><td colspan="5" class="px-6 py-10 text-center text-[14px] text-gray-500">No business profiles found.</td></tr>@endforelse
    </tbody></table></div>
</div>
@endsection
