<?php

declare(strict_types=1);

namespace App\Learner\Reservation\Application\BookLesson;

use App\Learner\Reservation\Domain\Book;
use App\Learner\Reservation\Domain\Lesson;

interface BookLessonRepository
{
    public function store(Book $book): void;

    public function isLessonAlreadyPendingOrAccepted(Lesson $lesson): bool;
}
