<?php

declare(strict_types=1);

namespace App\Learner\Reservation\Infrastructure\Laravel;

use App\Learner\Reservation\Application\BookLesson\BookLessonRepository;
use App\Learner\Reservation\Application\GetBookings\GetBookingsRepository;
use App\Learner\Reservation\Domain\AcceptationState;
use App\Learner\Reservation\Domain\Book;
use App\Learner\Reservation\Domain\Lesson;
use App\Shared\Infrastructure\Eloquent\EloquentBook;

class EloquentBookRepository implements BookLessonRepository, GetBookingsRepository
{
    public function store(Book $book): void
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

    public function getBookings(string $learnerId): array
    {
        return EloquentBook::where('learner_id', $learnerId)->where('status', '!=', AcceptationState::REFUSED)->get()->jsonSerialize();
    }
}
