<?php

declare(strict_types=1);

namespace App\Learner\Reservation\Infrastructure\Laravel;

use App\Learner\Reservation\Application\BookLesson\BookLessonRepository;
use App\Learner\Reservation\Application\GetBookings\BookingsResponse;
use App\Learner\Reservation\Application\GetBookings\GetBookingsRepository;
use App\Learner\Reservation\Domain\AcceptationState;
use App\Learner\Reservation\Domain\Booking;
use App\Learner\Reservation\Domain\Learner;
use App\Learner\Reservation\Domain\Lesson;
use App\Learner\Reservation\Domain\PaymentState;
use App\Shared\Domain\ValueObject\UuidValueObject;
use App\Shared\Infrastructure\Eloquent\EloquentBook;

class EloquentBookingRepository implements BookLessonRepository, GetBookingsRepository
{
    public function store(Booking $book): void
    {
        $bookEloquent = new EloquentBook();
        $bookEloquent->id = (string) $book->id();
        $bookEloquent->learner_id = $book->learner()->id();
        $bookEloquent->lesson_id = $book->lesson()->id();
        $bookEloquent->status = $book->acceptationState();

        $bookEloquent->save();
    }

    public function isLessonAvailable(Lesson $lesson): bool
    {
        return !EloquentBook::where('lesson_id', (string) $lesson->id())
            ->where('status', '!=', AcceptationState::REFUSED)
            ->exists();
    }

    public function getBookings(string $learnerId): BookingsResponse
    {
        $bookings = array_map(
            fn (array $booking) => new Booking(
                new UuidValueObject($booking['id'] ?? ''),
                new Learner(new UuidValueObject($booking['learner_id'] ?? '')),
                new Lesson(new UuidValueObject($booking['lesson_id'] ?? '')),
                AcceptationState::tryFrom($booking['status'] ?? ''),
                PaymentState::tryFrom($booking['payment_status'] ?? ''),
            ),
            EloquentBook::where('learner_id', $learnerId)->where('status', '!=', AcceptationState::REFUSED)->get()->toArray()
        );

        return new BookingsResponse(...$bookings);
    }
}
