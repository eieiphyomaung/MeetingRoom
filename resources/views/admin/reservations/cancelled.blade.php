@extends('layouts.admin')

@section('title', 'Cancelled Booking Requests')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <p class="text-slate-400 mt-1">Shows why the booking was rejected/cancelled.</p>
    </div>

    <form method="GET" action="{{ route('admin.reservations.cancelled') }}" class="w-full max-w-sm">
        <div class="relative">
            <span class="absolute inset-y-0 left-3 flex items-center text-slate-400">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="m21 21-4.3-4.3m1.3-5.2a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
                </svg>
            </span>

            <input name="q" value="{{ $q }}"
                   placeholder="Search room or booking ID..."
                   class="w-full rounded-xl bg-white/5 border border-white/10
                          px-10 py-3 text-slate-100 placeholder:text-slate-400
                          focus:outline-none focus:ring-2 focus:ring-rose-400/25" />
        </div>
    </form>
</div>

<div class="rounded-3xl bg-white/5 border border-white/10 shadow-xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full text-left">
            <thead class="bg-white/5 text-slate-400 text-sm">
                <tr>
                    <th class="px-6 py-4">Booking ID</th>
                    <th class="px-6 py-4">Room</th>
                    <th class="px-6 py-4">Organizer</th>
                    <th class="px-6 py-4">Date & Time</th>
                    <th class="px-6 py-4">Reject Reason</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-white/10">
            @forelse($cancelled as $r)
                <tr class="text-slate-100">
                    <td class="px-6 py-5 text-slate-300">#{{ $r->reserve_id }}</td>
                    <td class="px-6 py-5 font-semibold">{{ $r->room?->room_name ?? '—' }}</td>
                    <td class="px-6 py-5">{{ $r->user?->username ?? '—' }}</td>
                    <td class="px-6 py-5 text-slate-300">
                        {{ \Carbon\Carbon::parse($r->reserve_date)->format('M d, Y') }}
                        <div class="text-slate-500 text-sm">
                            {{ substr($r->start_time,0,5) }} - {{ substr($r->end_time,0,5) }}
                        </div>
                    </td>
                    <td class="px-6 py-5 text-rose-200">
                        {{ $r->reject_reason ?? 'No reason recorded.' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-10 text-center text-slate-400">
                        No cancelled bookings.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-6">
        {{ $cancelled->links() }}
    </div>
</div>

@endsection
