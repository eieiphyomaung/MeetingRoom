@extends('layouts.user')

@section('title', 'Booking Request')
@section('page_title', 'Booking Request')

@section('content')
@php
  // hourly times 08:00 -> 17:00
  $times = [];
  for ($h=8; $h<=17; $h++) {
    $times[] = sprintf('%02d:00', $h);
  }
@endphp

<div class="max-w-3xl mx-auto px-6 py-10">
  <div class="mb-6">
    <p class="text-slate-400">
      Room: <span class="text-teal-300 font-semibold">{{ $room->room_name }}</span>
    </p>
  </div>

  <div class="rounded-3xl bg-white/5 border border-white/10 shadow-2xl overflow-hidden">
    <form method="POST" action="{{ route('user.bookings.store') }}" class="p-8 space-y-6">
      @csrf
      <input type="hidden" name="room_id" value="{{ $room->room_id }}">

      <div>
        <label class="text-slate-300 font-semibold">Title</label>
        <input name="title" value="{{ old('title') }}" required
          class="mt-2 w-full rounded-2xl bg-white/5 border border-white/10 px-4 py-3 text-white
                 focus:outline-none focus:ring-2 focus:ring-teal-300/40"
          placeholder="e.g. Project meeting">
        @error('title') <div class="text-rose-300 text-sm mt-2">{{ $message }}</div> @enderror
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
          <label class="text-slate-300 font-semibold">Date</label>
          <input type="date" name="reserve_date" value="{{ old('reserve_date') }}" required
            class="mt-2 w-full rounded-2xl bg-white/5 border border-white/10 px-4 py-3 text-white
                   focus:outline-none focus:ring-2 focus:ring-teal-300/40">
          @error('reserve_date') <div class="text-rose-300 text-sm mt-2">{{ $message }}</div> @enderror
        </div>

        <div>
          <label class="text-slate-300 font-semibold">Start</label>
          <select name="start_time" required
            class="mt-2 w-full rounded-2xl bg-white/5 border border-white/10 px-4 py-3 text-white
                   focus:outline-none focus:ring-2 focus:ring-teal-300/40">
            <option value="" class="bg-slate-900">Select</option>
            @foreach($times as $t)
              <option value="{{ $t }}" @selected(old('start_time') === $t) class="bg-slate-900">{{ $t }}</option>
            @endforeach
          </select>
          @error('start_time') <div class="text-rose-300 text-sm mt-2">{{ $message }}</div> @enderror
        </div>

        <div>
          <label class="text-slate-300 font-semibold">End</label>
          <select name="end_time" required
            class="mt-2 w-full rounded-2xl bg-white/5 border border-white/10 px-4 py-3 text-white
                   focus:outline-none focus:ring-2 focus:ring-teal-300/40">
            <option value="" class="bg-slate-900">Select</option>
            @foreach($times as $t)
              <option value="{{ $t }}" @selected(old('end_time') === $t) class="bg-slate-900">{{ $t }}</option>
            @endforeach
          </select>
          @error('end_time') <div class="text-rose-300 text-sm mt-2">{{ $message }}</div> @enderror
        </div>
      </div>

      <div>
        <label class="text-slate-300 font-semibold">Description (optional)</label>
        <textarea name="description" rows="3"
          class="mt-2 w-full rounded-2xl bg-white/5 border border-white/10 px-4 py-3 text-white
                 focus:outline-none focus:ring-2 focus:ring-teal-300/40"
          placeholder="Short note...">{{ old('description') }}</textarea>
      </div>

      <div class="pt-2 flex justify-end gap-3">
        <a href="{{ route('rooms.index') }}"
          class="rounded-2xl px-6 py-3 bg-white/10 border border-white/10 text-slate-200 hover:bg-white/15">
          Cancel
        </a>

        <button type="submit"
          class="rounded-2xl px-6 py-3 bg-gradient-to-r from-sky-500 to-teal-400 text-slate-900 font-semibold
                 hover:from-sky-400 hover:to-teal-300">
          Submit Request
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
