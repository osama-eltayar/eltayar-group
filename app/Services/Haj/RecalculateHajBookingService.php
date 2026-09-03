<?php

namespace App\Services\Haj;

use App\Models\Booking;

class RecalculateHajBookingService
{
    public function execute(Booking $booking): void
    {
        $booking->update([
            'number_of_clients' => max($booking->hajClients()->count(), 1),
            'calculated_discount_amount' => (int) $booking->hajClients()->sum('discount_amount'),
        ]);
    }
}
