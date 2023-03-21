<?php

declare(strict_types=1);

namespace App\Learner\User\Infrastructure\Laravel;

use App\Learner\User\Application\CreateLearner\CreateLearnerRepository;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(CreateLearnerRepository::class, EloquentLearnerRepository::class);
    }
}
