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
        return $user->can('deleteBooking');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('deleteAnyBooking');
    }

    public function applyDiscount(User $user, Booking $booking): bool
    {
        return $user->can('applyDiscountBooking');
    }
}
