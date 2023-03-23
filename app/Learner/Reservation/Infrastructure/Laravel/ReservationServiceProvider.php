<?php

declare(strict_types=1);

namespace App\Learner\Reservation\Infrastructure\Laravel;

use App\Learner\Reservation\Application\BookLesson\BookLessonRepository;
use App\Learner\Reservation\Application\GetBookings\GetBookingsRepository;
use App\Learner\Reservation\Application\GetLessonsAvailable\GetLessonsAvailableRepository;
use Illuminate\Support\ServiceProvider;

class ReservationServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(GetLessonsAvailableRepository::class, EloquentLessonRepository::class);
        $this->app->bind(BookLessonRepository::class, EloquentBookingRepository::class);
        $this->app->bind(GetBookingsRepository::class, EloquentBookingRepository::class);
    }
}
