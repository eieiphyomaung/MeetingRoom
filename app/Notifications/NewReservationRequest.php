<?php

namespace App\Notifications;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class NewReservationRequest extends Notification
{
    use Queueable;

    public function __construct(public Reservation $reservation) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        $r = $this->reservation->load('room','user');

        return [
            'type' => 'reservation_pending',
            'reservation_id' => $r->id,
            'title' => $r->title,
            'room' => $r->room?->room_name,
            'user' => $r->user?->name,
            'date' => $r->date,
            'start_time' => $r->start_time,
            'end_time' => $r->end_time,
        ];
    }
}
