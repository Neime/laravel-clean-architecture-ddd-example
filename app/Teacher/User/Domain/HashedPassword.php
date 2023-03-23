<?php

declare(strict_types=1);

namespace App\Teacher\User\Domain;

final class HashedPassword implements \Stringable
{
    public const COST = 12;

    private function __construct(private readonly string $hashedPassword)
    {
    }

    public static function encode(string $plainPassword): self
    {
        if (empty($plainPassword)) {
            throw new \InvalidArgumentException('Password must be filled');
        }

        return new self(self::hash($plainPassword));
    }

    public static function fromHash(string $hashedPassword): self
    {
        return new self($hashedPassword);
    }

    public function match(string $plainPassword): bool
    {
        return password_verify($plainPassword, $this->hashedPassword);
    }

    private static function hash(string $plainPassword): string
    {
        /** @var string|bool|null $hashedPassword */
        $hashedPassword = password_hash($plainPassword, \PASSWORD_BCRYPT, ['cost' => self::COST]);

        if (\is_bool($hashedPassword)) {
            throw new \RuntimeException('Server error hashing password');
        }

        return (string) $hashedPassword;
    }

    public function __toString(): string
    {
        return $this->hashedPassword;
    }
}
