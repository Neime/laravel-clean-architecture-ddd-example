<?php

declare(strict_types=1);

namespace App\Learner\Reservation\Application\GetLessonsAvailable;

use App\Learner\Reservation\Domain\LessonAvailable;
use App\Shared\Application\Response;

final class LessonsAvailableResponse implements Response
{
    public readonly array $lessonsAvailable;

    public function __construct(LessonAvailable ...$lessonsAvailable)
    {
        $this->lessonsAvailable = $lessonsAvailable;
    }
}
