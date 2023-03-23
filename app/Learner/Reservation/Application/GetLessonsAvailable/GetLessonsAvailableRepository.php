<?php

declare(strict_types=1);

namespace App\Learner\Reservation\Application\GetLessonsAvailable;

interface GetLessonsAvailableRepository
{
    public function getLessonsAvailable(): LessonsAvailableResponse;
}
