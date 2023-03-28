<?php

declare(strict_types=1);

namespace App\Learner\Reservation\Domain;

final class Lesson
{
    public function __construct(
        private readonly LessonId $id,
        private readonly Teacher $teacher,
        private readonly PriceFormatted $priceFormatted,
        private readonly \DateTimeImmutable $startDate,
        private readonly \DateTimeImmutable $endDate,
    ) {
    }

    public function id(): LessonId
    {
        return $this->id;
    }

    public function teacherFullName(): string
    {
        return $this->teacher->fullName();
    }

    public function priceFormatted(): string
    {
        return (string) $this->priceFormatted;
    }

    public function date(): string
    {
        return sprintf('From %s to %s', $this->startDate->format('Y-m-d H:i'), $this->endDate->format('Y-m-d H:i'));
    }
}
