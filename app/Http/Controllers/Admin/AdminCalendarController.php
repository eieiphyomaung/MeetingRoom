<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Http\Request;

class AdminCalendarController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->get('date', now()->toDateString());

        $rooms = Room::where('is_active', 1)->orderBy('room_name')->get();

        // Show bookings for THAT selected day , Include BOTH approved + confirmed

        $reservations = Reservation::with(['room', 'user.department'])
            ->whereDate('reserve_date', $date)
            ->whereIn('status', ['approved', 'confirmed'])
            ->get();

        return view('admin.calendar.index', compact('date', 'rooms', 'reservations'));
    }
}
