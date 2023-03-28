<?php

declare(strict_types=1);

namespace App\Learner\Reservation\Infrastructure\Laravel;

use App\Learner\Reservation\Application\BookLesson\BookLessonRepository;
use App\Learner\Reservation\Application\GetBookings\BookingsResponse;
use App\Learner\Reservation\Application\GetBookings\GetBookingsRepository;
use App\Learner\Reservation\Domain\Booking;
use App\Learner\Reservation\Domain\Learner;
use App\Learner\Reservation\Domain\Lesson;
use App\Learner\Reservation\Domain\LessonId;
use App\Learner\Reservation\Domain\PaymentState;
use App\Learner\Reservation\Domain\PriceFormatted;
use App\Learner\Reservation\Domain\Teacher;
use App\Learner\Reservation\Domain\ValidationState;
use App\Shared\Domain\ValueObject\UuidValueObject;
use App\Shared\Infrastructure\Eloquent\EloquentBook;
use App\Shared\Infrastructure\Eloquent\EloquentLesson;
use App\Shared\Infrastructure\Eloquent\EloquentUser;

class EloquentBookingRepository implements BookLessonRepository, GetBookingsRepository
{
    public function store(Booking $book): void
    {
        $bookEloquent = new EloquentBook();
        $bookEloquent->id = (string) $book->id();
        $bookEloquent->learner_id = $book->learner()->id();
        $bookEloquent->lesson_id = $book->lessonId();
        $bookEloquent->status = $book->validationState();

        $bookEloquent->save();
    }

    public function isLessonAvailable(Lesson $lesson): bool
    {
        return !EloquentBook::where('lesson_id', (string) $lesson->id())
            ->where('status', '!=', ValidationState::REFUSED)
            ->exists();
    }

    public function getBookings(string $learnerId): BookingsResponse
    {
        $bookings = array_map(
            fn (array $booking) => new Booking(
                new UuidValueObject($booking['id'] ?? ''),
                new Learner(new UuidValueObject($booking['learner_id'] ?? '')),
                new LessonId($booking['lesson_id'] ?? ''),
                ValidationState::tryFrom($booking['status'] ?? ''),
                PaymentState::tryFrom($booking['payment_status'] ?? ''),
            ),
            EloquentBook::where('learner_id', $learnerId)->where('status', '!=', ValidationState::REFUSED)->get()->toArray()
        );

        return new BookingsResponse(...$bookings);
    }

    public function findLesson(UuidValueObject $lessonId): ?Lesson
    {
        $lesson = EloquentLesson::find((string) $lessonId);

        if (null === $lesson) {
            return null;
        }

        $teacher = EloquentUser::find($lesson->teacher_id);

        return new Lesson(
            new LessonId($lesson->id),
            new Teacher(
                new UuidValueObject($teacher->id),
                $teacher->firstname,
                $teacher->lastname,
            ),
            new PriceFormatted($lesson->amount, $lesson->currency),
            new \DateTimeImmutable($lesson->start_date),
            new \DateTimeImmutable($lesson->end_date),
        );
    }
}
