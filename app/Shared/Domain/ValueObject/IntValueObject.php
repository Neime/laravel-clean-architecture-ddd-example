<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

abstract class IntValueObject
{
    public function __construct(public readonly int $value)
    {
    }
}
