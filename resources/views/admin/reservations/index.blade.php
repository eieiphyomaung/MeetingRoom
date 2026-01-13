@extends('layouts.admin')

@section('title', 'Booking')

@section('content')

    {{-- TOP Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">

        {{-- Total Today --}}
        <div class="rounded-3xl bg-white/5 border border-white/10 p-6 shadow-xl">
            <div class="text-slate-400 text-sm">Total Bookings Today</div>
            <div class="mt-2 text-4xl font-bold text-slate-100">{{ $totalToday }}</div>
            <div class="mt-2 text-slate-500 text-sm">{{ now()->format('l, F j, Y') }}</div>
        </div>

        {{-- Confirmed --}}
        <div class="rounded-3xl bg-white/5 border border-white/10 p-6 shadow-xl">
            <div class="text-slate-400 text-sm">Approved Requests</div>
            <div class="mt-2 text-4xl font-bold text-emerald-200">{{ $confirmedCount }}</div>
        </div>

        {{-- Pending --}}
        <div class="rounded-3xl bg-white/5 border border-white/10 p-6 shadow-xl">
            <div class="text-slate-400 text-sm">Pending Requests</div>
            <div class="mt-2 text-4xl font-bold text-amber-200">{{ $pendingCount }}</div>
        </div>

        {{-- Cancelled Page) --}}
        <a href="{{ route('admin.reservations.cancelled') }}"
            class="rounded-3xl bg-white/5 border border-white/10 p-6 shadow-xl hover:bg-white/10 transition">
            <div class="text-slate-400 text-sm">Cancelled Requests</div>
            <div class="mt-2 text-4xl font-bold text-rose-200">{{ $cancelledCount }}</div>
            <div class="mt-2 text-slate-500 text-sm underline">View cancelled list</div>
        </a>

    </div>

    {{-- FILTER + SEARCH --}}
    <div class="rounded-3xl bg-white/5 border border-white/10 shadow-xl overflow-hidden">
        <div class="p-6 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

            {{-- Tabs --}}
            <div class="flex flex-wrap gap-2">
                @php
                    $tabs = [
                        'all' => 'All',
                        'approved' => 'Approved',
                        'pending' => 'Pending',
                        'cancelled' => 'Cancelled',
                    ];
                @endphp

                @foreach ($tabs as $key => $label)
                    <a href="{{ route('admin.reservations.index', ['status' => $key, 'q' => request('q')]) }}"
                        class="px-4 py-2 rounded-xl text-sm font-semibold border border-white/10
                          {{ $status === $key ? 'bg-white/10 text-teal-200' : 'text-slate-300 hover:bg-white/5' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            {{-- Search --}}
            <form method="GET" action="{{ route('admin.reservations.index') }}" class="w-full max-w-md">
                <input type="hidden" name="status" value="{{ $status }}">
                <div class="relative">
                    <span class="absolute inset-y-0 left-3 flex items-center text-slate-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-4.3-4.3m1.3-5.2a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                        </svg>
                    </span>

                    <input name="q" value="{{ $q }}" placeholder="Search by room or organizer..."
                        class="w-full rounded-xl bg-white/5 border border-white/10
                              px-10 py-3 text-slate-100 placeholder:text-slate-400
                              focus:outline-none focus:ring-2 focus:ring-sky-400/30" />
                </div>
            </form>

        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="min-w-full text-left">
                <thead class="bg-white/5 text-slate-400 text-sm">
                    <tr>
                        <th class="px-6 py-4">Booking ID</th>
                        <th class="px-6 py-4">Room</th>
                        <th class="px-6 py-4">Organizer</th>
                        <th class="px-6 py-4">Date & Time</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-white/10">
                    @forelse($reservations as $r)
                        <tr class="text-slate-100">
                            <td class="px-6 py-5 text-slate-300">
                                B{{ str_pad($r->reserve_id, 3, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-6 py-5 font-semibold">{{ $r->room?->room_name ?? '—' }}</td>
                            <td class="px-6 py-5">{{ $r->user?->username ?? '—' }}</td>
                            <td class="px-6 py-5 text-slate-300">
                                {{ \Carbon\Carbon::parse($r->reserve_date)->format('M d, Y') }}
                                <div class="text-slate-500 text-sm">
                                    {{ substr($r->start_time, 0, 5) }} - {{ substr($r->end_time, 0, 5) }}
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                @php
                                    $badge = match ($r->status) {
                                        'approved' => 'bg-emerald-400/15 text-emerald-200',
                                        'pending' => 'bg-amber-400/15 text-amber-200',
                                        'cancelled' => 'bg-rose-400/15 text-rose-200',
                                        default => 'bg-white/10 text-slate-200',
                                    };
                                    $statusLabel = match ($r->status) {
                                        'approved' => 'Approved',
                                        default => ucfirst($r->status),
                                    };
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $badge }}">
                                    {{ $statusLabel }}
                                </span>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-2">

                                    {{-- Approve / Reject buttons --}}
                                    @if ($r->status === 'pending')
                                        {{-- APPROVE --}}
                                        <form method="POST"
                                            action="{{ route('admin.reservations.approve', $r->reserve_id) }}"
                                            class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="px-4 py-2 rounded-xl bg-teal-500/20 border border-teal-400/20 text-teal-200 hover:bg-teal-500/30">
                                                Approve
                                            </button>
                                        </form>

                                        {{-- REJECT --}}
                                        <form method="POST"
                                            action="{{ route('admin.reservations.reject', $r->reserve_id) }}"
                                            class="inline">
                                            @csrf
                                            @method('PATCH')

                                            <input type="text" name="reject_reason" required placeholder="Reason"
                                                class="px-3 py-2 rounded-xl bg-white/5 border border-white/10 text-slate-100 placeholder:text-slate-500">

                                            <button type="submit"
                                                class="px-4 py-2 rounded-xl bg-rose-500/20 border border-rose-400/20 text-rose-200 hover:bg-rose-500/30">
                                                Reject
                                            </button>
                                        </form>
                                    @endif

                                </div>
                            </td>


                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-slate-400">
                                No bookings found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-6">
            {{ $reservations->links() }}
        </div>
    </div>
    {{-- Reject --}}
    <div id="rejectModal" class="hidden fixed inset-0 z-50">
        <div class="absolute inset-0 bg-black/60" onclick="closeRejectModal()"></div>

        <div class="relative mx-auto mt-24 w-[92%] max-w-xl rounded-3xl bg-slate-900 border border-white/10 p-7 shadow-2xl">
            <h3 class="text-xl font-bold mb-2">Reject Booking</h3>
            <p class="text-slate-400 text-sm mb-5">Please provide a reason (required).</p>

            <form id="rejectForm" method="POST">
                @csrf
                @method('PATCH')

                <textarea name="reject_reason" required maxlength="255"
                    class="w-full min-h-[110px] rounded-2xl bg-white/5 border border-white/10
                             px-4 py-3 text-slate-100 placeholder:text-slate-400
                             focus:outline-none focus:ring-2 focus:ring-rose-400/25"
                    placeholder="e.g. Time slot is not available / Wrong request / Duplicate booking"></textarea>

                <div class="mt-5 flex justify-end gap-3">
                    <button type="button" onclick="closeRejectModal()"
                        class="rounded-2xl px-5 py-3 bg-white/10 border border-white/10 text-slate-200 hover:bg-white/15">
                        Cancel
                    </button>

                    <button type="submit"
                        class="rounded-2xl px-5 py-3 bg-gradient-to-r from-rose-400 to-rose-300 text-slate-900 font-semibold hover:from-rose-300 hover:to-rose-200">
                        Reject
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const rejectModal = document.getElementById('rejectModal');
        const rejectForm = document.getElementById('rejectForm');

        function openRejectModal(reserveId) {
            rejectModal.classList.remove('hidden');
            rejectForm.action = `/admin/reservations/${reserveId}/reject`;
        }

        function closeRejectModal() {
            rejectModal.classList.add('hidden');
        }
    </script>

@endsection
