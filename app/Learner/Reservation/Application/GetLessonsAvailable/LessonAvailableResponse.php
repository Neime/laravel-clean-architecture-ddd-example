<?php

declare(strict_types=1);

namespace App\Learner\Reservation\Application\GetLessonsAvailable;

use App\Shared\Application\Response;

final class LessonAvailableResponse implements Response
{
    public function __construct(
        public readonly string $id,
    ) {
    }
}
