<?php

namespace App\Services\Booking;

use App\Enums\BookingStatus;
use App\Models\Booking;

class CancelBookingService
{
    public function execute(Booking $booking): void
    {
        $booking->update(['status' => BookingStatus::Cancelled]);

        $booking->omraClients()->delete();
        $booking->hajClients()->delete();
    }
}
