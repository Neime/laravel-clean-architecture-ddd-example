<?php

declare(strict_types=1);

namespace App\Learner\Reservation\Application\GetBookings;

use App\Learner\Reservation\Domain\Booking;
use App\Shared\Application\Response;

final class BookingsResponse implements Response
{
    public readonly array $bookings;

    public function __construct(Booking ...$bookings)
    {
        $this->bookings = $bookings;
    }
}
