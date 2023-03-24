<?php

declare(strict_types=1);

namespace App\Teacher\Lesson\Application\Shared;

use App\Shared\Domain\ValueObject\UuidValueObject;
use App\Teacher\Lesson\Domain\Booking;

interface ValidationStateBookingRepository
{
    public function find(UuidValueObject $bookingId): ?Booking;

    public function accepte(Booking $booking): void;

    public function refuse(Booking $booking): void;
}
