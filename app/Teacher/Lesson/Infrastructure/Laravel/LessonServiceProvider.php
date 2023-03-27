<?php

declare(strict_types=1);

namespace App\Teacher\Lesson\Infrastructure\Laravel;

use App\Teacher\Lesson\Application\CreateLesson\CreateLessonRepository;
use App\Teacher\Lesson\Application\Shared\ValidationStateBookingRepository;
use Illuminate\Support\ServiceProvider;

class LessonServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ValidationStateBookingRepository::class, EloquentBookingRepository::class);
        $this->app->bind(CreateLessonRepository::class, EloquentLessonRepository::class);
    }
}
