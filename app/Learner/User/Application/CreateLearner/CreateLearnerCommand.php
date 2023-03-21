<?php

declare(strict_types=1);

namespace App\Learner\User\Application\CreateLearner;

use App\Shared\Application\Command;

final class CreateLearnerCommand implements Command
{
    public function __construct(
        public readonly string $id,
        public readonly string $email,
        public readonly string $password,
        public readonly string $firstname,
        public readonly string $lastname,
    ) {
    }
}
