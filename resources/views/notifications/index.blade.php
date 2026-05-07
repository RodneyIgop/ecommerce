@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
<section class="bg-[#f5f3ef] min-h-screen py-10">
    <div class="max-w-[800px] mx-auto px-6 lg:px-10">
        <div class="flex items-center justify-between mb-8">
            <h1 class="font-serif-display text-[32px] text-gray-900">Notifications</h1>
            <form action="{{ route('notifications.read_all') }}" method="post">
                @csrf
                @method('patch')
                <button type="submit" class="text-[11px] font-semibold tracking-[0.12em] uppercase text-gray-600 hover:text-black">Mark all read</button>
            </form>
        </div>

        @if($notifications->count())
        <div class="space-y-3">
            @foreach($notifications as $notif)
            <div class="bg-white border {{ $notif->read_at ? 'border-[#e8e5e0]' : 'border-gray-400' }} p-5">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            @if(!$notif->read_at)
                                <span class="w-2 h-2 bg-[#111] rounded-full shrink-0"></span>
                            @endif
                            <h3 class="text-[14px] font-medium text-gray-900">{{ $notif->title }}</h3>
                        </div>
                        <p class="text-[13px] text-gray-700">{{ $notif->message }}</p>
                        <p class="text-[11px] text-gray-500 mt-2">{{ $notif->created_at->diffForHumans() }}</p>
                    </div>
                    @if(!$notif->read_at)
                    <form action="{{ route('notifications.read', $notif) }}" method="post" class="shrink-0">
                        @csrf
                        @method('patch')
                        <button type="submit" class="text-[11px] text-gray-500 hover:text-black underline">Mark read</button>
                    </form>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-6">{{ $notifications->links() }}</div>
        @else
        <div class="bg-white border border-[#e8e5e0] p-16 text-center">
            <p class="text-[13px] text-gray-600">No notifications yet.</p>
        </div>
        @endif
    </div>
</section>
@endsection
