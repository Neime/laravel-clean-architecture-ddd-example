<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid as RamseyUuid;
use Stringable;

class UuidValueObject implements Stringable
{
    public function __construct(public readonly string $value)
    {
        $this->ensureIsValidUuid($value);
    }

    public static function random(): self
    {
        return new static(RamseyUuid::uuid4()->toString());
    }

    public function equals(UuidValueObject $uuidValueObject): bool
    {
        return $this->value === $uuidValueObject->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    private function ensureIsValidUuid(string $id): void
    {
        if (!RamseyUuid::isValid($id)) {
            throw new InvalidArgumentException(sprintf('<%s> does not allow the value <%s>.', static::class, $id));
        }
    }
}
