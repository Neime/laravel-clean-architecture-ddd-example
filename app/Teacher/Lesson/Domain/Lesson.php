<?php

declare(strict_types=1);

namespace App\Teacher\Lesson\Domain;

use App\Shared\Domain\ValueObject\UuidValueObject;

final class Lesson
{
    public function __construct(
        private readonly UuidValueObject $id,
        private readonly Teacher $teacher,
        private readonly DateRange $dateRange,
        private readonly Price $price,
    ) {
    }

    public function id(): UuidValueObject
    {
        return $this->id;
    }

    public static function create(
        UuidValueObject $id,
        Teacher $teacher,
        DateRange $dateRange,
        Price $price,
    ): self {
        $lesson = new self(
            $id,
            $teacher,
            $dateRange,
            $price,
        );

        return $lesson;
    }

    public function teacher(): Teacher
    {
        return $this->teacher;
    }

    public function dateRange(): DateRange
    {
        return $this->dateRange;
    }

    public function price(): Price
    {
        return $this->price;
    }
}
