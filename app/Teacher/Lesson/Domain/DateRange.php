<?php

declare(strict_types=1);

namespace App\Teacher\Lesson\Domain;

final class DateRange
{
    private const FORMAT = \DATE_ATOM;
    private const TIMEZONE = 'UTC';

    public function __construct(private readonly \DateTimeImmutable $startDate, private readonly \DateTimeImmutable $endDate)
    {
        if ($startDate > $endDate) {
            throw new \InvalidArgumentException('End date must higher than start date');
        }
    }

    public function startDate(): \DateTimeImmutable
    {
        return $this->startDate;
    }

    public function endDate(): \DateTimeImmutable
    {
        return $this->endDate;
    }

    private static function timezone(): \DateTimeZone
    {
        return new \DateTimeZone((string) static::TIMEZONE);
    }

    public static function fromString(string $startDate, string $endDate): self
    {
        try {
            $startDate = new \DateTimeImmutable($startDate, static::timezone());
        } catch (\Exception $e) {
            throw new \InvalidArgumentException('Expected start date in format : {self::FORMAT}.');
        }

        try {
            $endDate = new \DateTimeImmutable($endDate, static::timezone());
        } catch (\Exception $e) {
            throw new \InvalidArgumentException('Expected end date in format : {self::FORMAT}.');
        }

        return new static($startDate, $endDate);
    }
}
