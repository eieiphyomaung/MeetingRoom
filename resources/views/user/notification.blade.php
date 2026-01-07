@extends('layouts.user')

@section('title', 'Notifications')
@section('page_title', 'Notifications')
@section('page_subtitle', 'Updates from Admin approvals, rejections, cancellations, and your actions.')

@section('content')
<div class="rounded-3xl bg-white/5 border border-white/10 overflow-hidden">
    <div class="p-6 border-b border-white/10 flex items-center justify-between">
        <div class="font-semibold">Latest</div>
        <div class="text-slate-400 text-sm">Unread: {{ $unreadCount }}</div>
    </div>

    <div class="divide-y divide-white/10">
        @forelse($notifications as $n)
            <div class="p-6 flex items-start gap-4">
                <div class="h-10 w-10 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center">
                    🔔
                </div>
                <div class="flex-1">
                    <div class="font-semibold">
                        {{ $n->data['title'] ?? 'Notification' }}
                    </div>
                    <div class="text-slate-400 text-sm mt-1">
                        {{ $n->data['message'] ?? '—' }}
                    </div>
                    <div class="text-slate-500 text-xs mt-2">
                        {{ $n->created_at->diffForHumans() }}
                    </div>
                </div>

                @if(is_null($n->read_at))
                    <span class="text-xs px-3 py-1 rounded-full bg-teal-400/15 border border-teal-400/20 text-teal-200">
                        NEW
                    </span>
                @endif
            </div>
        @empty
            <div class="p-10 text-center text-slate-400">No notifications yet.</div>
        @endforelse
    </div>
</div>
@endsection
