<?php

declare(strict_types=1);

namespace App\Bank\Wallet\Domain;

final class Price
{
    public function __construct(
        private readonly int $amount,
        private readonly Currency $currency,
    ) {
    }

    public function amount(): int
    {
        return $this->amount;
    }

    public function currency(): Currency
    {
        return $this->currency;
    }
}
