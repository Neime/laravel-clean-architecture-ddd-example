<?php

declare(strict_types=1);

namespace App\Teacher\Lesson\Application\ValidateBooking;

use App\Shared\Domain\ValueObject\UuidValueObject;
use App\Teacher\Lesson\Domain\Booking;

interface ValidateBookingRepository
{
    public function find(UuidValueObject $bookingId): ?Booking;

    public function validate(Booking $booking): void;
}
