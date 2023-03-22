<?php

namespace Tests;

use App\Learner\Reservation\Domain\AcceptationState;
use App\Shared\Infrastructure\Eloquent\EloquentBook;
use App\Shared\Infrastructure\Eloquent\EloquentUser;
use Illuminate\Foundation\Testing\WithFaker;

trait WithBooks
{
    use WithFaker;
    use WithLessons;

    protected function newBook(EloquentUser $learner, AcceptationState $state): EloquentBook
    {
        $book = new EloquentBook();
        $book->learner_id = $learner->id;
        $book->lesson_id = $this->newLessonAvailable()->id;
        $book->status = $state;
        $book->save();

        return $book;
    }

    protected function createRandomBooks(int $count, EloquentUser $learner, AcceptationState $state): array
    {
        $ids = [];
        foreach (range(1, $count) as $_) {
            $lesson = $this->newBook($learner, $state);
            $ids[] = $lesson->id;
        }

        return $ids;
    }
}
