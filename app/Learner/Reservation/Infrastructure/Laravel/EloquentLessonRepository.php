<?php

declare(strict_types=1);

namespace App\Learner\Reservation\Infrastructure\Laravel;

use App\Learner\Reservation\Application\GetLessonsAvailable\GetLessonsAvailableRepository;
use App\Learner\Reservation\Application\GetLessonsAvailable\LessonsAvailableResponse;
use App\Learner\Reservation\Domain\AcceptationState;
use App\Learner\Reservation\Domain\IsAvailable;
use App\Learner\Reservation\Domain\Lesson;
use App\Learner\Reservation\Domain\LessonAvailable;
use App\Shared\Domain\ValueObject\UuidValueObject;
use Illuminate\Support\Facades\DB;

class EloquentLessonRepository implements GetLessonsAvailableRepository
{
    public function getLessonsAvailable(): LessonsAvailableResponse
    {
        $lessons = DB::table('lesson')
            ->select('lesson.id')
            ->leftJoin('book', 'book.lesson_id', '=', 'lesson.id')
            ->where('book.status', '=', AcceptationState::REFUSED)
            ->orWhereNull('book.id')
            ->get()->toArray()
        ;

        $lessonsAvailable = array_map(
            fn (\stdClass $lessonAvailable) => new LessonAvailable(
                    new Lesson(new UuidValueObject($lessonAvailable->id ?? '')),
                    new IsAvailable(true)
                ),
            $lessons
        );

        return new LessonsAvailableResponse(...$lessonsAvailable);
    }
}
