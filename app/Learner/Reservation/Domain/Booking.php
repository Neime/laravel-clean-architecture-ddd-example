<?php

declare(strict_types=1);

namespace App\Learner\Reservation\Domain;

use App\Shared\Domain\ValueObject\UuidValueObject;

final class Booking
{
    public function __construct(
        private readonly UuidValueObject $id,
        private readonly Learner $learner,
        private readonly Lesson $lesson,
        private readonly ValidationState $validationState,
        private readonly PaymentState $paymentState,
    ) {
    }

    public static function create(
        UuidValueObject $id,
        Learner $learner,
        LessonAvailable $lessonAvailable,
        ValidationState $validationState,
    ): self {
        $book = new self(
            $id,
            $learner,
            $lessonAvailable->lesson(),
            $validationState,
            PaymentState::NEW,
        );

        return $book;
    }

    public function id(): UuidValueObject
    {
        return $this->id;
    }

    public function learner(): Learner
    {
        return $this->learner;
    }

    public function lesson(): Lesson
    {
        return $this->lesson;
    }

    public function validationState(): validationState
    {
        return $this->validationState;
    }
}
