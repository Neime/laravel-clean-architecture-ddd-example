<?php

declare(strict_types=1);

namespace App\Teacher\Lesson\Domain;

use App\Shared\Domain\ValueObject\UuidValueObject;

final class Teacher
{
    public function __construct(
        private readonly UuidValueObject $id,
    ) {
    }

    public function id(): UuidValueObject
    {
        return $this->id;
    }
}
