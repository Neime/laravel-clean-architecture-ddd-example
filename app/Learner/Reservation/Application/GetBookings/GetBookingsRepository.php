<?php

declare(strict_types=1);

namespace App\Learner\Reservation\Application\GetBookings;

interface GetBookingsRepository
{
    public function getBookings(string $learnerId): array;
}
