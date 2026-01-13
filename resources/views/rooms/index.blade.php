@extends('layouts.user')

@section('title', 'Reserve a Room')
@section('page_title', 'Reserve a Room')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

  {{-- Header ONLY once --}}
  <div class="mb-8">
    <p class="text-slate-400 mt-2">Browse available rooms and request a booking.</p>
  </div>

  @if(session('success'))
    <div class="mb-6 rounded-2xl border border-teal-400/20 bg-teal-400/10 px-4 py-3 text-teal-200">
      {{ session('success') }}
    </div>
  @endif

  <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
    @forelse($rooms as $room)
      <div class="rounded-3xl bg-white/5 border border-white/10 shadow-xl overflow-hidden">
        <div class="p-6">
          <div class="flex items-start justify-between">
            <div class="h-12 w-12 rounded-2xl bg-teal-400/15 border border-teal-400/10 flex items-center justify-center">
              <svg class="w-6 h-6 text-teal-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M3 21h18M6 21V4a1 1 0 011-1h4a1 1 0 011 1v17M14 21V8a1 1 0 011-1h2a1 1 0 011 1v13M8 7h2M8 11h2M8 15h2M16 11h2M16 15h2"/>
              </svg>
            </div>

            <span class="text-xs px-3 py-1 rounded-full bg-teal-400/15 text-teal-200 border border-teal-400/10">
              {{ $room->room_type ?? 'Room' }}
            </span>
          </div>

          <h3 class="mt-5 text-2xl font-bold tracking-tight text-slate-100">
            {{ $room->room_name }}
          </h3>

          <div class="mt-3 grid grid-cols-2 gap-3 text-sm text-slate-300">
            <div class="flex items-center gap-2">
              <span class="text-slate-400">📍</span>
              <span>{{ $room->floor ?? '—' }}</span>
            </div>
            <div class="flex items-center gap-2 justify-end">
              <span class="text-slate-400">👥</span>
              <span><span class="font-semibold text-slate-100">{{ $room->capacity }}</span> seats</span>
            </div>
          </div>

          @php
            $equipment = $room->equipment ?? [];
            if (is_string($equipment)) $equipment = json_decode($equipment, true) ?: [];
          @endphp

          @if(!empty($equipment))
            <div class="mt-5 flex flex-wrap gap-2">
              @foreach($equipment as $eq)
                <span class="px-3 py-1 rounded-full text-xs bg-white/10 border border-white/10 text-slate-200">
                  {{ $eq }}
                </span>
              @endforeach
            </div>
          @endif

          <div class="mt-6">
  <a href="{{ route('user.bookings.create', $room->room_id) }}"
     class="w-full inline-flex items-center justify-center gap-2 rounded-2xl px-5 py-3 font-semibold
            bg-gradient-to-r from-sky-500 to-teal-400 text-slate-900
            hover:from-sky-400 hover:to-teal-300 transition">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round"
            d="M8 7V3m8 4V3M3 11h18M5 5h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z"/>
    </svg>
    Book Now
  </a>
</div>


        </div>
      </div>
    @empty
      <div class="col-span-full rounded-3xl bg-white/5 border border-white/10 p-10 text-center text-slate-300">
        No active rooms available.
      </div>
    @endforelse
  </div>

</div>
@endsection
