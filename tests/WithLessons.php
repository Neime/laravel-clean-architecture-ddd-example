<?php

namespace Tests;

use App\Shared\Infrastructure\Eloquent\EloquentLesson;
use Illuminate\Foundation\Testing\WithFaker;

trait WithLessons
{
    use WithFaker;

    protected function newLesson(): EloquentLesson
    {
        $lessonAvailable = new EloquentLesson();
        $lessonAvailable->save();

        return $lessonAvailable;
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
