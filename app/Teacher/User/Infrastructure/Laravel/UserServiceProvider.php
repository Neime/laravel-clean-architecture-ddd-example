<?php

declare(strict_types=1);

namespace App\Teacher\User\Infrastructure\Laravel;

use App\Teacher\User\Application\CreateTeacher\CreateTeacherRepository;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(CreateTeacherRepository::class, EloquentTeacherRepository::class);
    }
}
