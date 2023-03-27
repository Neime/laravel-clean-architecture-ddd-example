<?php

declare(strict_types=1);

namespace App\Teacher\Lesson\Infrastructure\Laravel;

use App\Shared\Domain\ValueObject\UuidValueObject;
use App\Shared\Infrastructure\Eloquent\EloquentLesson;
use App\Shared\Infrastructure\Eloquent\EloquentUser;
use App\Teacher\Lesson\Application\CreateLesson\CreateLessonRepository;
use App\Teacher\Lesson\Domain\Lesson;
use App\Teacher\Lesson\Domain\Teacher;

class EloquentLessonRepository implements CreateLessonRepository
{
    public function findTeacher(UuidValueObject $teacherId): ?Teacher
    {
        $teacher = EloquentUser::find((string) $teacherId);

        if (null === $teacher) {
            return null;
        }

        return new Teacher(
            new UuidValueObject($teacher->id),
        );
    }

    public function store(Lesson $lesson): void
    {
        $lessonEloquent = new EloquentLesson();
        $lessonEloquent->teacher_id = $lesson->teacher()->id();
        $lessonEloquent->start_date = $lesson->dateRange()->startDate();
        $lessonEloquent->end_date = $lesson->dateRange()->endDate();
        $lessonEloquent->amount = $lesson->price()->amount();
        $lessonEloquent->currency = $lesson->price()->currency();

        $lessonEloquent->save();
    }
}
