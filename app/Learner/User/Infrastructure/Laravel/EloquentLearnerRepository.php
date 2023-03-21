<?php

declare(strict_types=1);

namespace App\Learner\User\Infrastructure\Laravel;

use App\Learner\User\Application\CreateLearner\CreateLearnerRepository;
use App\Learner\User\Domain\Email;
use App\Learner\User\Domain\HashedPassword;
use App\Learner\User\Domain\Learner;
use App\Shared\Infrastructure\Eloquent\EloquentUser;

class EloquentLearnerRepository implements CreateLearnerRepository
{
    public function store(Learner $learner, HashedPassword $password): void
    {
        $userEloquent = new EloquentUser();
        $userEloquent->id = (string) $learner->id();
        $userEloquent->email = $learner->email();
        $userEloquent->firstname = $learner->firstname();
        $userEloquent->lastname = $learner->lastname();
        $userEloquent->password = (string) $password;

        $userEloquent->save();
    }

    public function isEmailAlreadyExist(Email $email)
    {
        return EloquentUser::where('email', (string) $email)->exists();
    }
}
