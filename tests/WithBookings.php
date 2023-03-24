<?php

namespace Tests;

use App\Learner\Reservation\Domain\PaymentState;
use App\Learner\Reservation\Domain\ValidationState;
use App\Shared\Infrastructure\Eloquent\EloquentBook;
use App\Shared\Infrastructure\Eloquent\EloquentLesson;
use App\Shared\Infrastructure\Eloquent\EloquentUser;
use App\Teacher\Lesson\Domain\ValidationState as TeacherValidationState;
use Illuminate\Foundation\Testing\WithFaker;

trait WithBookings
{
    use WithFaker;
    use WithLessons;

    protected function newBook(EloquentUser $learner, ValidationState|TeacherValidationState $state, ?EloquentLesson $lesson = null): EloquentBook
    {
        $book = new EloquentBook();
        $book->learner_id = $learner->id;
        $book->lesson_id = $lesson ? $lesson->id : $this->newLesson()->id;
        $book->status = $state;
        $book->payment_status = PaymentState::NEW;
        $book->save();

        return $book;
    }

    protected function createRandomBooks(int $count, EloquentUser $learner, ValidationState|TeacherValidationState $state, ?EloquentLesson $lesson = null): array
    {
        $ids = [];
        foreach (range(1, $count) as $_) {
            $book = $this->newBook($learner, $state, $lesson);
            $ids[] = $book->id;
        }

        return $ids;
    }
}
