<?php

declare(strict_types=1);

namespace App\Teacher\Lesson\Domain;

use App\Shared\Domain\ValueObject\UuidValueObject;

final class Booking
{
    public function __construct(
        private readonly UuidValueObject $id,
        private readonly ValidationState $validationState,
    ) {
    }

    public function id(): UuidValueObject
    {
        return $this->id;
    }

    public function validationState(): ValidationState
    {
        return $this->validationState;
    }
}
