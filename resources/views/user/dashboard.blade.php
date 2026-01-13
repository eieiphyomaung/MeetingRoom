@extends('layouts.user')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

  {{-- Stats row --}}
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="rounded-3xl bg-white/5 border border-white/10 p-6">
      <div class="flex items-center justify-between">
        <div>
          <div class="text-4xl font-bold">{{ $stats['total_bookings'] }}</div>
          <div class="text-slate-400 mt-1">Total Bookings</div>
          <div class="text-slate-500 text-sm mt-1">{{ $stats['today'] }}</div>
        </div>
        <div class="h-12 w-12 rounded-2xl bg-teal-400/15 border border-teal-400/20 flex items-center justify-center">
          💼
        </div>
      </div>
    </div>

    <div class="rounded-3xl bg-white/5 border border-white/10 p-6">
      <div class="flex items-center justify-between">
        <div>
          <div class="text-4xl font-bold">{{ $stats['upcoming'] }}</div>
          <div class="text-slate-400 mt-1">Upcoming</div>
          <div class="text-slate-500 text-sm mt-1">Approved from today</div>
        </div>
        <div class="h-12 w-12 rounded-2xl bg-sky-400/15 border border-sky-400/20 flex items-center justify-center">
          ✅
        </div>
      </div>
    </div>

    <div class="rounded-3xl bg-white/5 border border-white/10 p-6">
      <div class="flex items-center justify-between">
        <div>
          <div class="text-4xl font-bold">{{ $stats['pending'] }}</div>
          <div class="text-slate-400 mt-1">Pending Approval</div>
          <div class="text-slate-500 text-sm mt-1">Waiting admin review</div>
        </div>
        <div class="h-12 w-12 rounded-2xl bg-amber-400/15 border border-amber-400/20 flex items-center justify-center">
          ⏳
        </div>
      </div>
    </div>
  </div>

  {{-- Long Recent Activity (replaces your unwanted block) --}}
  <div class="rounded-3xl bg-white/5 border border-white/10 overflow-hidden">
    <div class="px-6 py-5 border-b border-white/10">
      <div class="text-2xl font-bold text-slate-100">Recent Activity</div>
      <div class="text-slate-400 mt-1">Approvals, rejections, pending updates, cancellations.</div>
    </div>

    <div class="p-6 space-y-4">
      @forelse(($recentActivity ?? collect()) as $r)
        @php
          $icon = '•';
          $badge = 'bg-white/10 text-slate-200 border-white/10';
          $title = 'Booking updated';

          if ($r->status === 'approved') {
            $icon = '✓';
            $badge = 'bg-teal-500/15 text-teal-200 border-teal-400/20';
            $title = 'Booking approved';
          } elseif ($r->status === 'rejected') {
            $icon = '✕';
            $badge = 'bg-rose-500/15 text-rose-200 border-rose-400/20';
            $title = 'Booking rejected';
          } elseif ($r->status === 'pending') {
            $icon = '⏳';
            $badge = 'bg-amber-500/15 text-amber-200 border-amber-400/20';
            $title = 'Booking pending';
          } elseif ($r->status === 'cancelled') {
            $icon = '—';
            $badge = 'bg-slate-500/15 text-slate-200 border-white/10';
            $title = 'Booking cancelled';
          }

          $time = \Carbon\Carbon::parse($r->updated_at)->format('M j, g:i A');
        @endphp

        <div class="flex items-start gap-4 rounded-2xl bg-white/5 border border-white/10 p-4">
          <div class="h-11 w-11 rounded-2xl border flex items-center justify-center {{ $badge }}">
            <span class="font-bold">{{ $icon }}</span>
          </div>

          <div class="min-w-0 flex-1">
            <div class="flex items-center justify-between gap-4">
              <div class="font-semibold text-slate-100 truncate">
                {{ $title }} — {{ $r->room?->room_name ?? 'Room' }}
              </div>
              <div class="text-slate-500 text-sm whitespace-nowrap">{{ $time }}</div>
            </div>

            <div class="text-slate-300 text-sm mt-1">
              {{ $r->reserve_date }} • {{ \Carbon\Carbon::parse($r->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($r->end_time)->format('g:i A') }}
            </div>

            @if($r->status === 'rejected' && $r->reject_reason)
              <div class="text-rose-200 text-sm mt-2">
                Reason: {{ $r->reject_reason }}
              </div>
            @endif

            @if($r->title)
              <div class="text-slate-400 text-sm mt-2 truncate">
                {{ $r->title }}
              </div>
            @endif
          </div>
        </div>
      @empty
        <div class="text-slate-400 text-center py-10">
          No activity yet.
        </div>
      @endforelse
    </div>
  </div>

</div>
@endsection
