<?php

declare(strict_types=1);

namespace App\Learner\Reservation\Infrastructure\Laravel;

use App\Learner\Reservation\Application\GetLessonsAvailable\GetLessonsAvailableRepository;
use App\Shared\Infrastructure\Eloquent\EloquentLesson;

class EloquentLessonRepository implements GetLessonsAvailableRepository
{
    public function getLessonsAvailable(): array
    {
        return EloquentLesson::where('available', true)->get()->jsonSerialize();
    }
}
