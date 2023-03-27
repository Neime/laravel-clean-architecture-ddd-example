<?php

declare(strict_types=1);

namespace App\Teacher\Lesson\Domain;

final class Price
{
    public const EUR = 'EUR';

    public function __construct(public readonly int|float $amount, public readonly string $currency)
    {
        if (\is_float($amount)) {
            throw new \InvalidArgumentException('Price amount must be a integer value');
        }

        if ($amount < 0) {
            throw new \InvalidArgumentException(sprintf('%s must be a positive value', $amount));
        }

        if (!\in_array($currency, $this->getAvailableCurrencies())) {
            throw new \InvalidArgumentException(sprintf('%s must be a valid currency', $currency));
        }
    }

    private function getAvailableCurrencies(): array
    {
        return [self::EUR];
    }

    public function amount(): int
    {
        return $this->amount;
    }

    public function currency(): string
    {
        return $this->currency;
    }
}
