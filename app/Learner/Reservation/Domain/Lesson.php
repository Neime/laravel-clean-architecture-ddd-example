<?php

declare(strict_types=1);

namespace App\Learner\User\Domain;

use App\Shared\Domain\ValueObject\UuidValueObject;

final class Lesson
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
