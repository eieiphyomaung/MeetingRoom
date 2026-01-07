@extends('layouts.user')

@section('title', 'Home')

@section('page_title', 'Dashboard')
@section('page_subtitle')
    Welcome back, <span class="text-teal-300 font-semibold">{{ auth()->user()->username ?? auth()->user()->name }}</span>.
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Stats row --}}
    <div class="lg:col-span-3 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="rounded-3xl bg-white/5 border border-white/10 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-4xl font-bold">{{ $stats['total_bookings'] }}</div>
                    <div class="text-slate-400 mt-1">Total Bookings</div>
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
                </div>
                <div class="h-12 w-12 rounded-2xl bg-amber-400/15 border border-amber-400/20 flex items-center justify-center">
                    ⏳
                </div>
            </div>
        </div>
    </div>

    {{-- OPTION 6 UI: Find Available Slots --}}
    <div class="lg:col-span-2 rounded-3xl bg-white/5 border border-white/10 overflow-hidden">
        <div class="px-6 py-5 border-b border-white/10 flex items-center justify-between">
            <div>
                <h3 class="text-xl font-bold">⚡ Find Available Slots</h3>
                <p class="text-slate-400 text-sm mt-1">Pick a room + date + duration, then choose a free time.</p>
            </div>
            <a href="{{ route('calendar.index') }}"
               class="inline-flex items-center gap-2 rounded-2xl px-4 py-2 bg-white/5 border border-white/10 hover:bg-white/10 text-teal-200 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M8 7V3m8 4V3M3 11h18M5 5h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z"/>
                </svg>
                View Calendar
            </a>
        </div>

        <div class="p-6 space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="text-slate-300 font-semibold">Room</label>
                    <select class="mt-2 w-full rounded-2xl bg-white/5 border border-white/10 px-4 py-3 text-slate-100
                                   focus:outline-none focus:ring-2 focus:ring-teal-300/40">
                        <option>Any room</option>
                        <option>Meeting Room</option>
                        <option>Training Room</option>
                        <option>Conference Room</option>
                        <option>Interview Room</option>
                    </select>
                </div>

                <div>
                    <label class="text-slate-300 font-semibold">Date</label>
                    <input type="date"
                           class="mt-2 w-full rounded-2xl bg-white/5 border border-white/10 px-4 py-3 text-slate-100
                                  focus:outline-none focus:ring-2 focus:ring-teal-300/40">
                </div>

                <div>
                    <label class="text-slate-300 font-semibold">Duration</label>
                    <select class="mt-2 w-full rounded-2xl bg-white/5 border border-white/10 px-4 py-3 text-slate-100
                                   focus:outline-none focus:ring-2 focus:ring-teal-300/40">
                        <option>30 min</option>
                        <option selected>60 min</option>
                        <option>90 min</option>
                        <option>120 min</option>
                    </select>
                </div>
            </div>

            <div class="rounded-3xl bg-white/[0.03] border border-white/10 p-5">
                <div class="flex items-center justify-between gap-4 flex-wrap">
                    <div>
                        <div class="font-semibold">Suggested free times</div>
                        <div class="text-slate-400 text-sm">These will be filled from backend later.</div>
                    </div>

                    <button class="rounded-2xl px-5 py-2.5 bg-gradient-to-r from-sky-500 to-teal-400 text-slate-900 font-semibold
                                   hover:from-sky-400 hover:to-teal-300 transition">
                        Check availability
                    </button>
                </div>

                <div class="mt-4 flex flex-wrap gap-2">
                    @foreach(['09:00', '10:30', '13:00', '15:30', '17:00'] as $t)
                        <button class="px-4 py-2 rounded-2xl bg-white/5 border border-white/10 text-slate-200 hover:bg-white/10 transition">
                            {{ $t }}
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-end">
                <button class="inline-flex items-center gap-2 rounded-2xl px-6 py-3 bg-white/5 border border-white/10
                               hover:bg-white/10 text-slate-200 transition">
                    Continue to booking
                    <span>→</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Recent Activity (UI-only) --}}
    <div class="rounded-3xl bg-white/5 border border-white/10 overflow-hidden">
        <div class="px-6 py-5 border-b border-white/10">
            <h3 class="text-xl font-bold">Recent Activity</h3>
            <p class="text-slate-400 text-sm mt-1">Approvals, cancellations, updates, etc.</p>
        </div>

        <div class="p-6 space-y-4">
            <div class="flex items-start gap-3">
                <div class="h-10 w-10 rounded-2xl bg-emerald-400/15 border border-emerald-400/20 flex items-center justify-center">✓</div>
                <div>
                    <div class="font-semibold">Booking approved</div>
                    <div class="text-slate-400 text-sm">Your reservation was approved by Admin.</div>
                </div>
            </div>

            <div class="flex items-start gap-3">
                <div class="h-10 w-10 rounded-2xl bg-rose-400/15 border border-rose-400/20 flex items-center justify-center">✕</div>
                <div>
                    <div class="font-semibold">Booking rejected</div>
                    <div class="text-slate-400 text-sm">Reason: time overlaps with another booking.</div>
                </div>
            </div>

            <div class="flex items-start gap-3">
                <div class="h-10 w-10 rounded-2xl bg-sky-400/15 border border-sky-400/20 flex items-center justify-center">✎</div>
                <div>
                    <div class="font-semibold">Profile updated</div>
                    <div class="text-slate-400 text-sm">Your account info changed.</div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
