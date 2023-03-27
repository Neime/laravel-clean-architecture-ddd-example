<?php

declare(strict_types=1);

namespace App\Learner\Reservation\Application\BookLesson;

use App\Learner\Reservation\Domain\Booking;
use App\Learner\Reservation\Domain\Lesson;
use App\Shared\Domain\ValueObject\UuidValueObject;

interface BookLessonRepository
{
    public function store(Booking $book): void;

    public function isLessonAvailable(Lesson $lesson): bool;

    public function findLesson(UuidValueObject $lessonId): ?Lesson;
}
