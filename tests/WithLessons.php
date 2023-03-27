<?php

namespace Tests;

use App\Shared\Infrastructure\Eloquent\EloquentLesson;
use Illuminate\Foundation\Testing\WithFaker;

trait WithLessons
{
    use WithFaker;
    use WithTeacher;

    protected function newLesson(): EloquentLesson
    {
        $teacher = $this->newTeacher();

        $lesson = new EloquentLesson();
        $lesson->teacher_id = $teacher->id;
        $lesson->amount = 2000;
        $lesson->currency = 'EUR';
        $lesson->start_date = new \DateTime();
        $lesson->end_date = new \DateTime();

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
