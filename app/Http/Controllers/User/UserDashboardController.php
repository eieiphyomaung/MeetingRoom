<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserDashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $today = Carbon::today()->toDateString();

        $total = Reservation::where('user_id', $userId)->count();

        $pending = Reservation::where('user_id', $userId)
            ->where('status', 'pending')
            ->count();

        $approved = Reservation::where('user_id', $userId)
            ->where('status', 'approved')
            ->count();

        $upcoming = Reservation::where('user_id', $userId)
            ->where('status', 'approved')
            ->where('reserve_date', '>=', $today)
            ->count();

        $stats = [
            'total_bookings' => $total,
            'upcoming' => $upcoming,
            'pending' => $pending,
            'approved' => $approved,
            'today' => Carbon::today()->format('l, F j, Y'),
        ];

        $recentBookings = Reservation::with('room')
            ->where('user_id', $userId)
            ->orderByDesc('reserve_date')
            ->orderByDesc('start_time')
            ->limit(5)
            ->get();

            $recentActivity = Reservation::with('room')
            ->where('user_id', $userId)
            ->orderByDesc('updated_at')
            ->limit(6)
            ->get();

        // recent notifications (database)
        $notifications = Auth::user()
            ->notifications()
            ->latest()
            ->limit(6)
            ->get();

        return view('user.dashboard', compact('stats', 'recentBookings', 'recentActivity', 'notifications'));
    }
}
