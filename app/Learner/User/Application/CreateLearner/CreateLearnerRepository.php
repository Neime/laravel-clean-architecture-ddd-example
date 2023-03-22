<?php

declare(strict_types=1);

namespace App\Learner\User\Application\CreateLearner;

use App\Learner\User\Domain\Email;
use App\Learner\User\Domain\HashedPassword;
use App\Learner\User\Domain\Learner;

interface CreateLearnerRepository
{
    public function store(Learner $learner, HashedPassword $password): void;

    public function isEmailAlreadyExist(Email $email): bool;
}
