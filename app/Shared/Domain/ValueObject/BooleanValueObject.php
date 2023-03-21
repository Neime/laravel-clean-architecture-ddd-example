<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

abstract class BooleanValueObject
{
    public function __construct(public readonly bool $value)
    {
    }

    public function equals(BooleanValueObject $booleanValueObject): bool
    {
        return $this->value === $booleanValueObject->value;
    }

    public function isTrue(): bool
    {
        return true === $this->value;
    }

    public function isFalse(): bool
    {
        return false === $this->value;
    }
}
