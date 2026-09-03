<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;

class BookingPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('viewAnyBooking');
    }

    public function view(User $user, Booking $booking): bool
    {
        return $user->can('viewBooking');
    }

    public function create(User $user): bool
    {
        return $user->can('createBooking');
    }

    public function update(User $user, Booking $booking): bool
    {
        return $user->can('updateBooking');
    }

    public function delete(User $user, Booking $booking): bool
    {
        return false;
    }

    public function deleteAny(User $user): bool
    {
        return false;
    }

    public function applyDiscount(User $user, Booking $booking): bool
    {
        return $user->can('applyDiscountBooking');
    }

    public function markPending(User $user, Booking $booking): bool
    {
        return $user->can('markPendingBooking');
    }

    public function markCompleted(User $user, Booking $booking): bool
    {
        return $user->can('markCompletedBooking');
    }

    public function cancel(User $user, Booking $booking): bool
    {
        return $user->can('cancelBooking');
    }

    public function refund(User $user, Booking $booking): bool
    {
        return $user->can('refundBooking');
    }
}
