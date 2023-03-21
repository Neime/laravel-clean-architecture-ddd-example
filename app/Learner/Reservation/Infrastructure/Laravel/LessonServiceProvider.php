<?php

declare(strict_types=1);

namespace App\Learner\Reservation\Infrastructure\Laravel;

use App\Learner\Reservation\Application\GetLessonsAvailable\GetLessonsAvailableRepository;
use Illuminate\Support\ServiceProvider;

class LessonServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(GetLessonsAvailableRepository::class, EloquentLessonRepository::class);
    }
}
