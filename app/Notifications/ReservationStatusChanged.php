<?php

namespace App\Notifications;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReservationStatusChanged extends Notification
{
    use Queueable;

    protected Reservation $reservation;

    protected string $status;

    protected ?string $rejectReason;

    public function __construct(Reservation $reservation, string $status, ?string $rejectReason = null)
    {
        $this->reservation = $reservation;
        $this->status = $status;
        $this->rejectReason = $rejectReason;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $message = (new MailMessage)
            ->subject('Reservation '.ucfirst($this->status))
            ->line('Your reservation has been '.$this->status.'.');

        if ($this->rejectReason) {
            $message->line('Reason: '.$this->rejectReason);
        }

        return $message;
    }

    public function toArray($notifiable)
    {
        return [
            'reservation_id' => $this->reservation->reserve_id ?? $this->reservation->id,
            'status' => $this->status,
            'reason' => $this->rejectReason,
        ];
    }
}
