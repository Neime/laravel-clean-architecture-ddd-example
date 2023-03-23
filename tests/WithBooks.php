<?php

namespace Tests;

use App\Learner\Reservation\Domain\AcceptationState;
use App\Shared\Infrastructure\Eloquent\EloquentBook;
use App\Shared\Infrastructure\Eloquent\EloquentLesson;
use App\Shared\Infrastructure\Eloquent\EloquentUser;
use Illuminate\Foundation\Testing\WithFaker;

trait WithBooks
{
    use WithFaker;
    use WithLessons;

    protected function newBook(EloquentUser $learner, AcceptationState $state, ?EloquentLesson $lesson = null): EloquentBook
    {
        $book = new EloquentBook();
        $book->learner_id = $learner->id;
        $book->lesson_id = $lesson ? $lesson->id : $this->newLesson()->id;
        $book->status = $state;
        $book->save();

        return $book;
    }

    protected function createRandomBooks(int $count, EloquentUser $learner, AcceptationState $state, ?EloquentLesson $lesson = null): array
    {
        $ids = [];
        foreach (range(1, $count) as $_) {
            $book = $this->newBook($learner, $state, $lesson);
            $ids[] = $book->id;
        }

        return $ids;
    }
}
