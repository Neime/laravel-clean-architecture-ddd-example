<?php

declare(strict_types=1);

namespace App\Learner\Reservation\Domain;

use App\Shared\Domain\ValueObject\BooleanValueObject;

final class IsAvailable extends BooleanValueObject
{
    public function __construct(public readonly bool $value)
    {
        if (false === $value) {
            throw new LessonIsNotAvailableException();
        }
    }
}
