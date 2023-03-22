<?php

declare(strict_types=1);

namespace App\Learner\Reservation\Domain;

use App\Shared\Domain\ValueObject\UuidValueObject;

final class Book
{
    public function __construct(
        private readonly UuidValueObject $id,
        private readonly Learner $learner,
        private readonly Lesson $lesson,
        private readonly AcceptationState $acceptationState,
    ) {
    }

    public static function create(
        UuidValueObject $id,
        Learner $learner,
        Lesson $lesson,
        AcceptationState $acceptationState,
    ): self {
        $book = new self(
            $id,
            $learner,
            $lesson,
            $acceptationState,
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

    public function acceptationState(): AcceptationState
    {
        return $this->acceptationState;
    }
}
