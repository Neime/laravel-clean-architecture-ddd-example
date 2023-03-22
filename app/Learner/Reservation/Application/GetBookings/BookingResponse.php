<?php

declare(strict_types=1);

namespace App\Learner\Reservation\Application\GetBookings;

use App\Shared\Application\Response;

final class BookingResponse implements Response
{
    public function __construct(
        public readonly string $id,
    ) {
    }
}
