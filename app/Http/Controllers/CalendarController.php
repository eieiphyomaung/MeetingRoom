<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->get('date', now()->toDateString());

        $rooms = Room::where('is_active', 1)->orderBy('room_name')->get();

        // User sees only their bookings, also allow both statuses
        $reservations = Reservation::with(['room', 'user.department'])
            ->where('user_id', Auth::id())
            ->whereDate('reserve_date', $date)
            ->whereIn('status', ['approved', 'confirmed'])
            ->get();

        return view('user.calendar.index', compact('date', 'rooms', 'reservations'));
    }
}
