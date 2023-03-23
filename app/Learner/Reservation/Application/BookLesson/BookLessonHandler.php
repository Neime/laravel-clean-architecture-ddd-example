<?php

declare(strict_types=1);

namespace App\Learner\Reservation\Application\BookLesson;

use App\Learner\Reservation\Domain\AcceptationState;
use App\Learner\Reservation\Domain\Book;
use App\Learner\Reservation\Domain\IsAvailable;
use App\Learner\Reservation\Domain\Learner;
use App\Learner\Reservation\Domain\Lesson;
use App\Learner\Reservation\Domain\LessonAvailable;
use App\Shared\Application\CommandHandler;
use App\Shared\Domain\ValueObject\UuidValueObject;

final class BookLessonHandler implements CommandHandler
{
    public function __construct(
        private readonly BookLessonRepository $bookLessonRepository,
    ) {
    }

    public function __invoke(BookLessonCommand $command): void
    {
        $id = new UuidValueObject($command->id);
        $lessonId = new UuidValueObject($command->lessonId);
        $learnerId = new UuidValueObject($command->learnerId);

        $lesson = new Lesson($lessonId);
        $learner = new Learner($learnerId);

        $lessonAvailable = new LessonAvailable($lesson, new IsAvailable($this->bookLessonRepository->isLessonAvailable($lesson)));

        $book = Book::create($id, $learner, $lessonAvailable, AcceptationState::PENDING);

        $this->bookLessonRepository->store($book);
    }
}
