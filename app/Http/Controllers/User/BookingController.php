<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function create($roomId)
    {
        $room = Room::where('room_id', $roomId)->firstOrFail();
        return view('user.bookings.create', compact('room'));
    }

    public function store(Request $request)
{
    $data = $request->validate([
        'room_id' => ['required'],
        'title' => ['required','string','max:255'],
        'reserve_date' => ['required','date'],
        'start_time' => ['required'],
        'end_time' => ['required'],
        'description' => ['nullable','string'],
    ]);

    if ($data['start_time'] >= $data['end_time']) {
        return back()->withErrors(['end_time' => 'End time must be after start time.'])->withInput();
    }

    // prevent overlap with pending/approved
    $overlap = Reservation::where('room_id', $data['room_id'])
        ->where('reserve_date', $data['reserve_date'])
        ->whereIn('status', ['approved','pending'])
        ->where(function($q) use ($data){
            $q->whereBetween('start_time', [$data['start_time'], $data['end_time']])
              ->orWhereBetween('end_time', [$data['start_time'], $data['end_time']])
              ->orWhere(function($qq) use ($data){
                  $qq->where('start_time','<=',$data['start_time'])
                     ->where('end_time','>=',$data['end_time']);
              });
        })->exists();

    if ($overlap) {
        return back()->withErrors(['start_time' => 'This time slot is already taken (or pending).'])->withInput();
    }

    Reservation::create([
        'user_id' => Auth::id(),
        'room_id' => $data['room_id'],
        'title' => $data['title'],
        'reserve_date' => $data['reserve_date'],
        'start_time' => $data['start_time'],
        'end_time' => $data['end_time'],
        'description' => $data['description'] ?? null,
        'status' => 'pending',
    ]);

    return redirect()->route('rooms.index')
        ->with('success', 'Booking request submitted. Waiting for admin approval.');
}
}
