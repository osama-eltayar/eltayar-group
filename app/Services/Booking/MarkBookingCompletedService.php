<?php

namespace App\Services\Booking;

use App\Enums\BookingStatus;
use App\Models\Booking;

class MarkBookingCompletedService
{
    public function execute(Booking $booking): void
    {
        $booking->update(['status' => BookingStatus::Completed]);
    }
}
