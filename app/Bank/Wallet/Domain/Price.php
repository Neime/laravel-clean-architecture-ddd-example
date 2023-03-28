<?php

declare(strict_types=1);

namespace App\Bank\Wallet\Domain;

final class Price
{
    public const EUR = 'EUR';

    public function __construct(
        private readonly int $amount,
        private readonly string $currency,
    ) {
        if ($amount < 0) {
            throw new \InvalidArgumentException(sprintf('%s must be a positive value', $amount));
        }

        if (!\in_array($currency, $this->getAvailableCurrencies())) {
            throw new \InvalidArgumentException(sprintf('%s must be a valid currency', $currency));
        }
    }

    public function getAvailableCurrencies(): array
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
