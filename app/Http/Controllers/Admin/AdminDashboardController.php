<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'pending_requests' => Reservation::where('status', 'pending')->count(),
            'total_rooms' => Room::count(),
            'departments' => Department::count(),
            'active_users' => User::count(),
        ];

        $recent = Reservation::with(['user', 'room'])
            ->latest('reserve_id')
            ->take(8)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent'));
    }
}
