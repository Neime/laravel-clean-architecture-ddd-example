<?php

declare(strict_types=1);

namespace App\Learner\Reservation\Domain;

final class LessonAvailable
{
    public function __construct(
        private readonly Lesson $lesson,
        private readonly IsAvailable $isAvailable,
    ) {
    }

    public function id(): string
    {
        return $this->lesson->id()->__toString();
    }

    public function lesson(): Lesson
    {
        return $this->lesson;
    }

    public function toArray(): array
    {
        return [
            'id' => (string) $this->lesson->id(),
            'is_available' => $this->isAvailable->value,
            'teacher' => $this->lesson->teacherFullName(),
            'price' => (string) $this->lesson()->priceFormatted(),
            'date' => $this->lesson()->date(),
        ];
    }
}
