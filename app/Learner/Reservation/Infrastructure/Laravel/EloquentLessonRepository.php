<?php

declare(strict_types=1);

namespace App\Learner\Reservation\Infrastructure\Laravel;

use App\Learner\Reservation\Application\GetLessonsAvailable\GetLessonsAvailableRepository;
use App\Learner\Reservation\Application\GetLessonsAvailable\LessonsAvailableResponse;
use App\Learner\Reservation\Domain\IsAvailable;
use App\Learner\Reservation\Domain\Lesson;
use App\Learner\Reservation\Domain\LessonAvailable;
use App\Learner\Reservation\Domain\LessonId;
use App\Learner\Reservation\Domain\PriceFormatted;
use App\Learner\Reservation\Domain\Teacher;
use App\Learner\Reservation\Domain\ValidationState;
use App\Shared\Domain\ValueObject\UuidValueObject;
use Illuminate\Support\Facades\DB;

class EloquentLessonRepository implements GetLessonsAvailableRepository
{
    public function getLessonsAvailable(): LessonsAvailableResponse
    {
        // retrieve the lessons that are available if they do not have an associated booking or if the bookings are refused (and not awaiting validation, or validated)
        $lessons = DB::table('lesson')
            ->select('lesson.id', 'lesson.start_date', 'lesson.end_date', 'lesson.amount', 'lesson.currency', 'users.id as teacherId', 'users.firstname', 'users.lastname')
            ->leftJoin('book', 'book.lesson_id', '=', 'lesson.id')
            ->join('users', 'users.id', '=', 'lesson.teacher_id')
            ->where('book.status', '=', ValidationState::REFUSED)
            ->orWhereNull('book.id')
            ->orderBy('lesson.start_date')
            ->get()->toArray()
        ;

        $lessonsAvailable = array_map(
            fn (\stdClass $lessonAvailable) => new LessonAvailable(
                new Lesson(
                    new LessonId($lessonAvailable->id ?? ''),
                    new Teacher(new UuidValueObject($lessonAvailable->teacherId), $lessonAvailable->firstname, $lessonAvailable->lastname),
                    new PriceFormatted($lessonAvailable->amount, $lessonAvailable->currency),
                    new \DateTimeImmutable($lessonAvailable->start_date),
                    new \DateTimeImmutable($lessonAvailable->end_date),
                ),
                new IsAvailable(true)
            ),
            $lessons
        );

        return new LessonsAvailableResponse(...$lessonsAvailable);
    }
}
