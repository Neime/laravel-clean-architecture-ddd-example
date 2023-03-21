<?php

declare(strict_types=1);

namespace App\Learner\User\Domain;

final class Credentials
{
    public function __construct(
        public readonly Email $email,
        public readonly HashedPassword $password,
    ) {
    }
}
