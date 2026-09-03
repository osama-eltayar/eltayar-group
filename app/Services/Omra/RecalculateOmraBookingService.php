<?php

namespace App\Services\Omra;

use App\Models\Booking;

class RecalculateOmraBookingService
{
    public function execute(Booking $booking): void
    {
        $totalPrice = (int) $booking->omraClients()->sum('price');
        $calculatedDiscountAmount = (int) $booking->omraClients()->sum('discount_amount');
        $finalPrice = max(0, $totalPrice - (int) $booking->discount_amount - $calculatedDiscountAmount);

        $booking->forceFill([
            'number_of_clients' => max($booking->omraClients()->count(), 1),
            'total_price' => $totalPrice,
            'calculated_discount_amount' => $calculatedDiscountAmount,
            'final_price' => $finalPrice,
            'balance' => max(0, $finalPrice - (int) $booking->paid),
        ])->saveQuietly();
    }
}
