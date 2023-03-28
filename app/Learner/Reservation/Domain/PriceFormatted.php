<?php

declare(strict_types=1);

namespace App\Learner\Reservation\Domain;

final class PriceFormatted
{
    public const EUR = 'EUR';
    public const DEFAULT_LOCALE = 'fr_FR';

    public function __construct(
        private readonly int $amount,
        private readonly string $currency,
        private readonly ?string $locale = null,
    ) {
    }

    private function amountDecimal(): float
    {
        return round($this->amount / 100);
    }

    private function format(): string
    {
        $numberFormatter = new \NumberFormatter($this->locale ?? self::DEFAULT_LOCALE, \NumberFormatter::CURRENCY);

        return $numberFormatter->formatCurrency($this->amountDecimal(), $currency ?? self::EUR);
    }

    public function __toString()
    {
        return $this->format();
    }
}
