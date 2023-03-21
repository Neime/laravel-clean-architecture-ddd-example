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
        $lessonAvailable->available = false;
        $lessonAvailable->save();

        return $lessonAvailable;
    }

    protected function newLessonAvailable(): EloquentLesson
    {
        $lessonAvailable = new EloquentLesson();
        $lessonAvailable->available = true;
        $lessonAvailable->save();

        return $lessonAvailable;
    }

    protected function createRandomLessonsAvailable(int $lessonsCount): array
    {
        $ids = [];
        foreach (range(1, $lessonsCount) as $_) {
            $lesson = $this->newLessonAvailable();
            $ids[] = $lesson->id;
        }

        return $ids;
    }

    protected function createRandomLessons(int $lessonsCount): array
    {
        $ids = [];
        foreach (range(1, $lessonsCount) as $_) {
            $lesson = $this->newLesson();
            $ids[] = $lesson->id;
        }

        return $ids;
    }
}
