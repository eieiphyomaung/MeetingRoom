<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today();

        // Stats (Auto refresh daily)
        $totalToday = Reservation::whereDate('reserve_date', $today)->count();
        $confirmedCount = Reservation::where('status', 'confirmed')->count();
        $pendingCount = Reservation::where('status', 'pending')->count();
        $cancelledCount = Reservation::where('status', 'cancelled')->count();

        // Filters
        $status = $request->query('status', 'all');
        $q = $request->query('q');

        $reservations = Reservation::with(['user', 'room'])
            ->when($status !== 'all', fn ($query) => $query->where('status', $status))
            ->when($q, function ($query) use ($q) {
                $query->whereHas('room', fn ($r) => $r->where('room_name', 'like', "%{$q}%"))
                    ->orWhereHas('user', fn ($u) => $u->where('username', 'like', "%{$q}%"));
            })
            ->orderByDesc('reserve_date')
            ->orderBy('start_time')
            ->paginate(10)
            ->withQueryString();

        return view('admin.reservations.index', compact(
            'totalToday', 'confirmedCount', 'pendingCount', 'cancelledCount',
            'reservations', 'status', 'q'
        ));
    }

    // Cancelled Page
    public function cancelled(Request $request)
    {
        $q = $request->query('q');

        $cancelled = Reservation::with(['user', 'room'])
            ->where('status', 'cancelled')
            ->when($q, function ($query) use ($q) {
                $query->whereHas('room', fn ($r) => $r->where('room_name', 'like', "%{$q}%"))
                    ->orWhere('reserve_id', $q);
            })
            ->orderByDesc('reserve_date')
            ->paginate(10)
            ->withQueryString();

        return view('admin.reservations.cancelled', compact('cancelled', 'q'));
    }
}
