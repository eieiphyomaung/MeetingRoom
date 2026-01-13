@extends('layouts.user')
@section('title', 'Calendar')

@section('content')
    @php
        $startHour = 8;
        $endHour = 18;
        $pxPerMin = 1;
        $dayMinutes = ($endHour - $startHour) * 60;
        $gridHeight = $dayMinutes * $pxPerMin;

        $eventThemes = [
            'bg-sky-500/15 border-sky-400/25',
            'bg-teal-500/15 border-teal-400/25',
            'bg-cyan-500/15 border-cyan-400/25',
            'bg-indigo-500/15 border-indigo-400/25',
            'bg-blue-500/15 border-blue-400/25',
        ];
    @endphp

    {{-- Title --}}
    <div class="flex items-start justify-between gap-6 mb-6">
        <div>
            <h1 class="text-3xl font-bold text-slate-100">Calendar</h1>
            <p class="text-slate-400 mt-1">
                Daily schedule by room —
                <span class="text-slate-200 font-semibold">{{ \Carbon\Carbon::parse($date)->format('D, F j, Y') }}</span>
            </p>
        </div>

        {{-- Date picker button --}}
        <div class="relative h-11 w-11">
            <input id="dateInput" type="date" value="{{ $date }}" class="absolute inset-0 opacity-0 cursor-pointer"
                onchange="window.location='?date=' + this.value">

            <button type="button"
                onclick="document.getElementById('dateInput').showPicker ? document.getElementById('dateInput').showPicker() : document.getElementById('dateInput').click()"
                class="absolute inset-0 rounded-2xl bg-white/5 border border-white/10 hover:bg-white/10 transition flex items-center justify-center text-teal-300"
                title="Pick date">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8 7V3m8 4V3M3 11h18M5 5h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z" />
                </svg>
            </button>
        </div>
    </div>

    <div class="rounded-3xl bg-white/5 border border-white/10 overflow-hidden">
        <div class="grid" style="grid-template-columns: 96px repeat({{ max(1, $rooms->count()) }}, minmax(0, 1fr));">
            <div class="px-4 py-4 border-b border-white/10 text-slate-400 font-semibold">Time</div>

            @foreach ($rooms as $room)
                <div class="px-4 py-4 border-b border-white/10 min-w-0">
                    <div class="font-semibold text-slate-100 truncate">{{ $room->room_name }}</div>
                    <div class="text-slate-400 text-sm truncate">Capacity: {{ $room->capacity }}</div>
                </div>
            @endforeach
        </div>

        <div class="grid" style="grid-template-columns: 96px repeat({{ max(1, $rooms->count()) }}, minmax(0, 1fr));">
            <div class="border-r border-white/10 bg-white/[0.03]">
                <div class="relative" style="height: {{ $gridHeight }}px;">
                    @for ($h = $startHour; $h <= $endHour; $h++)
                        @php
                            $top = ($h - $startHour) * 60 * $pxPerMin;
                            $label = \Carbon\Carbon::createFromTime($h, 0)->format('g A');
                        @endphp
                        <div class="absolute left-0 right-0 flex items-start gap-2 px-4"
                            style="top: {{ $top }}px;">
                            <div class="text-slate-400 text-sm">{{ $label }}</div>
                        </div>
                        @if ($h < $endHour)
                            <div class="absolute left-0 right-0 border-t border-white/10"
                                style="top: {{ $top }}px;"></div>
                        @endif
                    @endfor
                </div>
            </div>

            @foreach ($rooms as $room)
                @php $roomEvents = $reservations->where('room_id', $room->room_id); @endphp

                <div class="border-r border-white/10 min-w-0">
                    <div class="relative" style="height: {{ $gridHeight }}px;">
                        @for ($h = $startHour; $h < $endHour; $h++)
                            @php $top = ($h - $startHour) * 60 * $pxPerMin; @endphp
                            <div class="absolute left-0 right-0 border-t border-white/10"
                                style="top: {{ $top }}px;"></div>
                        @endfor

                        @foreach ($roomEvents as $ev)
                            @php
                                $day = \Carbon\Carbon::parse($date);

                                $start = $day->copy()->setTimeFromTimeString(substr($ev->start_time, 0, 5));
                                $end = $day->copy()->setTimeFromTimeString(substr($ev->end_time, 0, 5));
                                if ($end->lessThanOrEqualTo($start)) {
                                    $end->addDay();
                                }

                                $visibleStart = $start->copy()->max($day->copy()->setTime($startHour, 0));
                                $visibleEnd = $end->copy()->min($day->copy()->setTime($endHour, 0));

                                $startMin = ($visibleStart->hour - $startHour) * 60 + $visibleStart->minute;
                                $endMin = ($visibleEnd->hour - $startHour) * 60 + $visibleEnd->minute;

                                $top = max(0, $startMin) * $pxPerMin;
                                $height = max(34, ($endMin - $startMin) * $pxPerMin);

                                $title = $ev->title ?: 'Booking';
                                $timeLabel = $start->format('g:i A') . ' - ' . $end->format('g:i A');

                                // Dept NAME only
                                $deptName = $ev->user?->department?->depart_name ?? 'No Department';

                                $theme = $eventThemes[$room->room_id % count($eventThemes)];
                            @endphp

                            <div class="absolute left-2 right-2 rounded-2xl border shadow-lg shadow-slate-900/20 {{ $theme }} overflow-hidden"
                                style="top: {{ $top }}px; height: {{ $height }}px;">

                                {{-- Content vertically centered --}}
                                <div class="h-full px-3 py-2 flex flex-col justify-center">
                                    <div class="flex items-start justify-between gap-2">
                                        <div class="text-slate-100 font-semibold text-sm leading-tight truncate">
                                            {{ $title }}
                                        </div>

                                        <span
                                            class="shrink-0 px-2 py-0.5 rounded-full text-[10px] bg-white/10 border border-white/10 text-slate-200 truncate max-w-[140px]">
                                            {{ $deptName }}
                                        </span>
                                    </div>

                                    <div class="text-slate-300 text-xs mt-1 leading-tight truncate">
                                        {{ $timeLabel }}
                                    </div>
                                </div>

                            </div>
                        @endforeach

                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
