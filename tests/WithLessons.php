<?php

namespace Tests;

use App\Shared\Infrastructure\Eloquent\EloquentLesson;
use Illuminate\Foundation\Testing\WithFaker;

trait WithLessons
{
    use WithFaker;
    use WithTeacher;

    protected function newLesson(
        int $amount = 2000,
        string $currency = 'EUR',
        \DateTimeImmutable $startDate = new \DateTimeImmutable('2023-12-30 07:00'),
        \DateTimeImmutable $endDate = new \DateTimeImmutable('2023-12-30 08:00')
    ): EloquentLesson {
        $teacher = $this->newTeacher();

        $lesson = new EloquentLesson();
        $lesson->teacher_id = $teacher->id;
        $lesson->amount = $amount;
        $lesson->currency = $currency;
        $lesson->start_date = $startDate;
        $lesson->end_date = $endDate;

        $lesson->save();

        return $lesson;
    }

    protected function createRandomLessons(int $lessonsCount): array
    {
        $lessons = [];
        foreach (range(1, $lessonsCount) as $_) {
            $lessons[] = $this->newLesson();
        }

        return $lessons;
    }
}
