<?php

declare(strict_types=1);

namespace App\Teacher\User\Application\CreateTeacher;

use App\Shared\Application\Command;

final class CreateTeacherCommand implements Command
{
    public function __construct(
        public readonly string $id,
        public readonly string $email,
        public readonly string $password,
        public readonly string $companyName,
        public readonly string $firstname,
        public readonly string $lastname,
    ) {
    }
}
