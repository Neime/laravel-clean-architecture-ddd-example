<?php

declare(strict_types=1);

namespace App\Learner\Reservation\Application\BookLesson;

use App\Learner\Reservation\Domain\Booking;
use App\Learner\Reservation\Domain\IsAvailable;
use App\Learner\Reservation\Domain\Learner;
use App\Learner\Reservation\Domain\LessonAvailable;
use App\Learner\Reservation\Domain\ValidationState;
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

        $lesson = $this->bookLessonRepository->findLesson($lessonId);
        if (null === $lesson) {
            throw new LessonNotExistException();
        }

        $learner = new Learner($learnerId);

        $lessonAvailable = new LessonAvailable($lesson, new IsAvailable($this->bookLessonRepository->isLessonAvailable($lesson)));

        $booking = Booking::create($id, $learner, $lessonAvailable, ValidationState::PENDING);

        $this->bookLessonRepository->store($booking);
    }
}
