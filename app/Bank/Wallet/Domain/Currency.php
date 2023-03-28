<?php

declare(strict_types=1);

namespace App\Bank\Wallet\Domain;

final class Currency
{
    public const EUR = 'EUR';
    public const USD = 'USD';

    public function __construct(
        private readonly string $currency,
    ) {
        if (!\in_array($currency, $this->getAvailableCurrencies())) {
            throw new \InvalidArgumentException(sprintf('%s must be a valid currency', $currency));
        }
    }

    public function getAvailableCurrencies(): array
    {
        return [self::EUR, self::USD];
    }

    public function currency(): string
    {
        return $this->currency;
    }

    public function __toString()
    {
        return $this->currency;
    }

    public function isEqualsTo(Currency $currency): bool
    {
        return $this->currency() === $currency->currency();
    }
}
