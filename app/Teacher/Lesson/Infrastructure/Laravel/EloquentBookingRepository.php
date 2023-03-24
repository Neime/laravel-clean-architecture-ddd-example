<?php

declare(strict_types=1);

namespace App\Teacher\Lesson\Infrastructure\Laravel;

use App\Shared\Domain\ValueObject\UuidValueObject;
use App\Shared\Infrastructure\Eloquent\EloquentBook;
use App\Teacher\Lesson\Application\Shared\ValidationStateBookingRepository;
use App\Teacher\Lesson\Domain\Booking;
use App\Teacher\Lesson\Domain\ValidationState;

class EloquentBookingRepository implements ValidationStateBookingRepository
{
    public function find(UuidValueObject $bookingId): ?Booking
    {
        $book = EloquentBook::find((string) $bookingId);

        if (null === $book) {
            return null;
        }

        return new Booking(
            new UuidValueObject($book->id),
            ValidationState::tryFrom($book->status),
        );
    }

    public function accepte(Booking $booking): void
    {
        $book = EloquentBook::find((string) $booking->id());
        $book->status = ValidationState::ACCEPTED;

        $book->save();
    }

    public function refuse(Booking $booking): void
    {
        $book = EloquentBook::find((string) $booking->id());
        $book->status = ValidationState::REFUSED;

        $book->save();
    }
}
