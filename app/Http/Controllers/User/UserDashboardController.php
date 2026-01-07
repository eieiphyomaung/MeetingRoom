<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        // UI-ready numbers (wire real queries later)
        $stats = [
            'total_bookings' => 0,
            'upcoming' => 0,
            'pending' => 0,
        ];

        // notifications badge in layout
        $unreadCount = Auth::user()->unreadNotifications()->count();

        return view('user.dashboard', compact('stats', 'unreadCount'));
    }
}
