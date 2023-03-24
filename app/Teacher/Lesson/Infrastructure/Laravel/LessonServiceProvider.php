<?php

declare(strict_types=1);

namespace App\Teacher\Lesson\Infrastructure\Laravel;

use App\Teacher\Lesson\Application\ValidateBooking\ValidateBookingRepository;
use Illuminate\Support\ServiceProvider;

class LessonServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ValidateBookingRepository::class, EloquentBookingRepository::class);
    }
}
