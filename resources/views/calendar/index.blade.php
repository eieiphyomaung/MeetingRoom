@extends('layouts.user')
@section('title', 'Calendar')

@section('content')
@php
  $startHour = 8;
  $endHour = 17; // ✅ 5 PM
  $pxPerMin = 1; // 60px per hour
  $dayMinutes = ($endHour - $startHour) * 60;
  $gridHeight = $dayMinutes * $pxPerMin;

  // cool-tone event colors
  $eventThemes = [
    'bg-sky-500/15 border-sky-400/25',
    'bg-teal-500/15 border-teal-400/25',
    'bg-cyan-500/15 border-cyan-400/25',
    'bg-indigo-500/15 border-indigo-400/25',
    'bg-blue-500/15 border-blue-400/25',
  ];
@endphp

<div class="flex items-start justify-between gap-6 mb-6">
  <div>
    <h2 class="text-3xl font-bold tracking-tight">Calendar</h2>
    <p class="text-slate-400 mt-1">Daily schedule by room — <span class="text-slate-200 font-semibold">{{ \Carbon\Carbon::parse($date)->format('D, F j, Y') }}</span></p>
  </div>

  <div class="flex items-center gap-3">
    <input id="dateInput" type="date" value="{{ $date }}" class="hidden"
           onchange="window.location='?date=' + this.value">

    <button type="button"
      onclick="document.getElementById('dateInput').showPicker ? document.getElementById('dateInput').showPicker() : document.getElementById('dateInput').click()"
      class="h-11 w-11 rounded-2xl bg-white/5 border border-white/10 hover:bg-white/10 transition flex items-center justify-center text-teal-300"
      title="Pick date">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round"
          d="M8 7V3m8 4V3M3 11h18M5 5h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z"/>
      </svg>
    </button>
  </div>
</div>

{{-- ✅ No horizontal scroll: minmax(0,1fr) + overflow hidden --}}
<div class="rounded-3xl bg-white/5 border border-white/10 overflow-hidden">
  {{-- header --}}
  <div class="grid"
       style="grid-template-columns: 96px repeat({{ max(1, $rooms->count()) }}, minmax(0, 1fr));">
    <div class="px-4 py-4 border-b border-white/10 text-slate-400 font-semibold">
      Time
    </div>

    @foreach($rooms as $room)
      <div class="px-4 py-4 border-b border-white/10 min-w-0">
        <div class="font-semibold text-slate-100 truncate">{{ $room->room_name }}</div>
        <div class="text-slate-400 text-sm truncate">Capacity: {{ $room->capacity }}</div>
      </div>
    @endforeach
  </div>

  {{-- body --}}
  <div class="grid"
       style="grid-template-columns: 96px repeat({{ max(1, $rooms->count()) }}, minmax(0, 1fr));">
    {{-- time column --}}
    <div class="border-r border-white/10 bg-white/[0.03]">
      <div class="relative" style="height: {{ $gridHeight }}px;">
        @for($h = $startHour; $h <= $endHour; $h++)
          @php
            $top = ($h - $startHour) * 60 * $pxPerMin;
            $label = \Carbon\Carbon::createFromTime($h,0)->format('g A');
          @endphp

          <div class="absolute left-0 right-0 flex items-start gap-2 px-4" style="top: {{ $top }}px;">
            <div class="text-slate-400 text-sm">{{ $label }}</div>
          </div>

          @if($h < $endHour)
            <div class="absolute left-0 right-0 border-t border-white/10" style="top: {{ $top }}px;"></div>
          @endif
        @endfor
      </div>
    </div>

    {{-- room columns --}}
    @foreach($rooms as $room)
      @php
        $roomEvents = $reservations->where('room_id', $room->room_id);
      @endphp

      <div class="border-r border-white/10 min-w-0">
        <div class="relative" style="height: {{ $gridHeight }}px;">
          {{-- hour lines --}}
          @for($h = $startHour; $h < $endHour; $h++)
            @php $top = ($h - $startHour) * 60 * $pxPerMin; @endphp
            <div class="absolute left-0 right-0 border-t border-white/10" style="top: {{ $top }}px;"></div>
          @endfor

          {{-- events --}}
          @foreach($roomEvents as $ev)
            @php
              $start = \Carbon\Carbon::parse($ev->start_time);
              $end = \Carbon\Carbon::parse($ev->end_time);

              // clamp to visible window
              $visibleStart = $start->copy()->max(\Carbon\Carbon::parse($date)->setTime($startHour, 0));
              $visibleEnd   = $end->copy()->min(\Carbon\Carbon::parse($date)->setTime($endHour, 0));

              $startMin = ($visibleStart->hour - $startHour) * 60 + $visibleStart->minute;
              $endMin   = ($visibleEnd->hour - $startHour) * 60 + $visibleEnd->minute;

              $top = max(0, $startMin) * $pxPerMin;
              $height = max(34, ($endMin - $startMin) * $pxPerMin);

              $title = $ev->title ?: 'Booking';
              $desc = $ev->description ?: ($ev->user?->username ?? 'User');
              $timeLabel = $start->format('g:i A') . ' - ' . $end->format('g:i A');

              $theme = $eventThemes[$room->room_id % count($eventThemes)];
            @endphp

            <div class="absolute left-2 right-2 rounded-2xl border shadow-lg shadow-slate-900/20 px-3 py-2 {{ $theme }}"
                 style="top: {{ $top }}px; height: {{ $height }}px;">
              <div class="text-slate-100 font-semibold truncate">{{ $title }}</div>
              <div class="text-slate-300 text-sm truncate">{{ $timeLabel }}</div>
              <div class="text-slate-400 text-xs truncate">{{ $desc }}</div>
            </div>
          @endforeach
        </div>
      </div>
    @endforeach
  </div>
</div>
@endsection
