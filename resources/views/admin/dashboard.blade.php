@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-10">

  <div class="rounded-3xl bg-white/5 border border-white/10 p-6 shadow-xl">
    <div class="text-5xl font-extrabold text-teal-300">{{ $stats['pending_requests'] }}</div>
    <div class="mt-2 text-slate-300">Pending Requests</div>
  </div>

  <div class="rounded-3xl bg-white/5 border border-white/10 p-6 shadow-xl">
    <div class="text-5xl font-extrabold text-sky-300">{{ $stats['total_rooms'] }}</div>
    <div class="mt-2 text-slate-300">Total Rooms</div>
  </div>

  <div class="rounded-3xl bg-white/5 border border-white/10 p-6 shadow-xl">
    <div class="text-5xl font-extrabold text-cyan-300">{{ $stats['departments'] }}</div>
    <div class="mt-2 text-slate-300">Departments</div>
  </div>

  <div class="rounded-3xl bg-white/5 border border-white/10 p-6 shadow-xl">
    <div class="text-5xl font-extrabold text-indigo-300">{{ $stats['active_users'] }}</div>
    <div class="mt-2 text-slate-300">Active Users</div>
  </div>

</div>

<div class="rounded-3xl bg-white/5 border border-white/10 shadow-xl overflow-hidden">
  <div class="px-6 py-5 text-xl font-bold text-slate-100">Recent Booking Requests</div>

  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead class="text-slate-400">
        <tr class="border-t border-white/10">
          <th class="text-left px-6 py-4 font-semibold">User</th>
          <th class="text-left px-6 py-4 font-semibold">Room</th>
          <th class="text-left px-6 py-4 font-semibold">Date/Time</th>
          <th class="text-left px-6 py-4 font-semibold">Status</th>
        </tr>
      </thead>

      <tbody class="text-slate-200">
        @forelse($recent as $r)
          <tr class="border-t border-white/10">
            <td class="px-6 py-5">{{ $r->user?->username ?? '—' }}</td>
            <td class="px-6 py-5">{{ $r->room?->room_name ?? '—' }}</td>

            <td class="px-6 py-5">
              <div>{{ $r->reserve_date }}</div>
              <div class="text-slate-400">{{ $r->start_time }} - {{ $r->end_time }}</div>
            </td>

            <td class="px-6 py-5">
              @php
                $badge = match($r->status) {
                  'pending' => 'bg-amber-500/15 text-amber-200 border border-amber-400/20',
                  'approved' => 'bg-teal-500/15 text-teal-200 border border-teal-400/20',
                  'rejected' => 'bg-rose-500/15 text-rose-200 border border-rose-400/20',
                  'cancelled' => 'bg-white/10 text-slate-200 border border-white/10',
                  default => 'bg-white/10 text-slate-200 border border-white/10',
                };
              @endphp
              <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $badge }}">
                {{ ucfirst($r->status) }}
              </span>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="4" class="px-6 py-8 text-slate-400">No booking requests found.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

@endsection
