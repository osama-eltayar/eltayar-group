<?php

namespace App\Services\Booking;

use App\Enums\TransactionType;
use App\Models\Booking;

class RecalculateBookingPaidService
{
    public function execute(Booking $booking): void
    {
        $paid = (int) $booking->transactions()->where('type', TransactionType::IN)->sum('amount');

        $booking->update(['paid' => $paid]);
    }
}
