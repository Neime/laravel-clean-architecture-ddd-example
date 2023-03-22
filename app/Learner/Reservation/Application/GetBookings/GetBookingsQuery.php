<?php

declare(strict_types=1);

namespace App\Learner\Reservation\Application\GetBookings;

use App\Shared\Application\Query;

final class GetBookingsQuery implements Query
{
    public function __construct(
        public readonly string $learnerId,
    ) {
    }
}
