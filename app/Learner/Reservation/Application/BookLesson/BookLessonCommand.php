<?php

declare(strict_types=1);

namespace App\Learner\Reservation\Application\BookLesson;

use App\Shared\Application\Command;

final class BookLessonCommand implements Command
{
    public function __construct(
        public readonly string $id,
        public readonly string $learnerId,
        public readonly string $lessonId,
    ) {
    }
}
