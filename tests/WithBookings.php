<?php

namespace Tests;

use App\Bank\Wallet\Domain\PaymentStatus;
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
    use WithWallet;

    protected function newBook(EloquentUser $learner, ValidationState|TeacherValidationState $state, ?EloquentLesson $lesson = null, ?PaymentStatus $paymentStatus = null): EloquentBook
    {
        $wallet = $this->newWallet();
        $lesson = $lesson ?? $this->newLesson();
        $transaction = $this->newTransaction($wallet, $lesson->amount, $lesson->currency, $paymentStatus?->value ?? PaymentStatus::COMPLETED->value);

        $book = new EloquentBook();
        $book->learner_id = $learner->id;
        $book->lesson_id = $lesson->id;
        $book->status = $state;
        $book->transaction_id = $transaction->id;
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
