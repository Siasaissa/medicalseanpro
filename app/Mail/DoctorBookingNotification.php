<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DoctorBookingNotification extends Mailable
{
    use Queueable, SerializesModels;

    public Booking $booking;
    public string $actionUrl;

    public function __construct(Booking $booking, string $actionUrl)
    {
        $this->booking = $booking;
        $this->actionUrl = $actionUrl;
    }

    public function build(): self
    {
        return $this
            ->subject('New Appointment Booking #' . $this->booking->id)
            ->view('emails.doctor-booking-notification');
    }
}

