<?php

declare(strict_types=1);

namespace App\Learner\User\Domain;

final class LessonAvailable
{
    public function __construct(
        private readonly Lesson $lesson,
    ) {
    }

    public function id(): string
    {
        return $this->lesson->id()->__toString();
    }
}
