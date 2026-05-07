@extends('layouts.app')

@section('title', 'Transaction Logs')

@section('content')
<section class="bg-[#f5f3ef] min-h-screen py-10">
    <div class="max-w-[1200px] mx-auto px-6 lg:px-10">
        <h1 class="font-serif-display text-[32px] text-gray-900 mb-8">Transaction Logs</h1>

        @if($logs->count())
        <div class="bg-white border border-[#e8e5e0]">
            <div class="grid grid-cols-6 gap-4 p-4 border-b border-[#e8e5e0] text-[10px] font-semibold tracking-[0.1em] uppercase text-gray-500">
                <span>Time</span>
                <span>User</span>
                <span>Action</span>
                <span>Entity</span>
                <span>Entity ID</span>
                <span>IP</span>
            </div>
            @foreach($logs as $log)
            <div class="grid grid-cols-6 gap-4 p-4 border-b border-[#e8e5e0] last:border-b-0 text-[12px]">
                <span class="text-gray-500">{{ $log->created_at->format('M d H:i') }}</span>
                <span>{{ $log->user?->name ?? 'System' }}</span>
                <span class="font-medium">{{ $log->action }}</span>
                <span class="text-gray-600">{{ class_basename($log->entity_type) }}</span>
                <span class="text-gray-500">{{ $log->entity_id }}</span>
                <span class="text-gray-500">{{ $log->ip_address ?? 'N/A' }}</span>
            </div>
            @endforeach
        </div>
        <div class="mt-6">{{ $logs->links() }}</div>
        @else
        <div class="bg-white border border-[#e8e5e0] p-16 text-center">
            <p class="text-[13px] text-gray-600">No transaction logs found.</p>
        </div>
        @endif
    </div>
</section>
@endsection
