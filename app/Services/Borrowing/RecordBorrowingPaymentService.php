<?php

namespace App\Services\Borrowing;

use App\Models\Borrowing;

class RecordBorrowingPaymentService
{
    public function execute(Borrowing $borrowing, int $amount): void
    {
        $paid = min($borrowing->paid + $amount, $borrowing->amount);
        $remaining = max($borrowing->amount - $paid, 0);

        $borrowing->update([
            'paid' => $paid,
            'remaining' => $remaining,
            'ended_at' => $remaining === 0 ? now() : $borrowing->ended_at,
        ]);
    }
}
