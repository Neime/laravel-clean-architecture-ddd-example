<?php

declare(strict_types=1);

namespace App\Learner\Reservation\Application\GetBookings;

use App\Shared\Application\Response;

final class BookingsResponse implements Response
{
    public readonly array $bookings;

    public function __construct(BookingResponse ...$bookings)
    {
        $this->bookings = $bookings;
    }
}
