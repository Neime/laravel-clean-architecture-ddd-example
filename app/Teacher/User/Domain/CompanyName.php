<?php

declare(strict_types=1);

namespace App\Teacher\User\Domain;

use App\Shared\Domain\ValueObject\StringValueObject;

final class CompanyName extends StringValueObject
{
    public function __construct(
        public readonly string $value,
    ) {
        if (empty($value)) {
            throw new \InvalidArgumentException('Company name must be filled');
        }
    }
}
