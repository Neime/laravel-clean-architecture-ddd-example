<?php

declare(strict_types=1);

namespace App\Learner\Reservation\Domain;

use App\Shared\Domain\ValueObject\UuidValueObject;

final class Teacher
{
    public function __construct(
        private readonly UuidValueObject $id,
        private readonly ?string $firstName,
        private readonly ?string $lastName,
    ) {
    }

    public function id(): UuidValueObject
    {
        return $this->id;
    }

    public function fullName(): string
    {
        return (string) $this->firstName.' '.$this->lastName;
    }
}
