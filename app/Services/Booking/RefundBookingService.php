<?php

namespace App\Services\Booking;

use App\Enums\BookingStatus;
use App\Enums\Currency;
use App\Enums\PaymentMethod;
use App\Enums\TransactionType;
use App\Models\Booking;
use App\Models\Transaction;

class RefundBookingService
{
    public function execute(Booking $booking, PaymentMethod $paymentMethod, int $amount): void
    {
        $booking->update(['status' => BookingStatus::Refunded]);

        Transaction::create([
            'branch_id' => $booking->branch_id,
            'user_id' => auth()->id(),
            'client_id' => $booking->client_id,
            'transactionable_type' => Booking::class,
            'transactionable_id' => $booking->id,
            'about' => __('booking.refund'),
            'amount' => $amount,
            'currency_code' => Currency::EGYPTIAN_POUND,
            'payment_method' => $paymentMethod,
            'type' => TransactionType::OUT,
        ]);
    }
}
