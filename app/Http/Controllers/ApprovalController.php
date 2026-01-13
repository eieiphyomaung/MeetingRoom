<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Notifications\ReservationStatusChanged;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    public function approve(Reservation $reservation)
    {
        $reservation->update([
            'status' => 'approved',
            'reject_reason' => null,
        ]);

        // Notify user
        if ($reservation->user) {
            $reservation->user->notify(new ReservationStatusChanged($reservation, 'approved'));
        }

        return back()->with('success', 'Booking approved.');
    }

    public function reject(Request $request, Reservation $reservation)
    {
        $request->validate([
            'reject_reason' => ['required', 'string', 'max:255'],
        ]);

        $reservation->update([
            'status' => 'rejected',
            'reject_reason' => $request->reject_reason,
        ]);

        // Notify user
        if ($reservation->user) {
            $reservation->user->notify(new ReservationStatusChanged($reservation, 'rejected', $request->reject_reason));
        }

        return back()->with('success', 'Booking rejected.');
    }
}
