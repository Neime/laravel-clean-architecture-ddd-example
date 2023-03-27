<?php

declare(strict_types=1);

namespace App\Teacher\Lesson\Application\CreateLesson;

use App\Shared\Application\CommandHandler;
use App\Shared\Domain\ValueObject\UuidValueObject;
use App\Teacher\Lesson\Domain\DateRange;
use App\Teacher\Lesson\Domain\Lesson;
use App\Teacher\Lesson\Domain\Price;

final class CreateLessonHandler implements CommandHandler
{
    public function __construct(
        private readonly CreateLessonRepository $createLessonRepository,
    ) {
    }

    public function __invoke(CreateLessonCommand $command): void
    {
        $id = new UuidValueObject($command->id);
        $teacherId = new UuidValueObject($command->teacherId);
        $dateRange = DateRange::fromString($command->startDate, $command->endDate);
        $price = new Price($command->amount, $command->currency);

        $teacher = $this->createLessonRepository->findTeacher($teacherId);
        if (null === $teacher) {
            throw new TeacherNotExistException();
        }

        $lesson = Lesson::create($id, $teacher, $dateRange, $price);

        $this->createLessonRepository->store($lesson);
    }
}
