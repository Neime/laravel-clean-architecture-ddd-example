<?php

declare(strict_types=1);

namespace App\Teacher\Lesson\Application\CreateLesson;

use App\Shared\Application\Command;

final class CreateLessonCommand implements Command
{
    public function __construct(
        public readonly string $id,
        public readonly string $teacherId,
        public readonly string $startDate,
        public readonly string $endDate,
        public readonly int|float $amount,
        public readonly string $currency,
    ) {
    }
}
