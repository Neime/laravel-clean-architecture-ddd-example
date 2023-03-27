<?php

declare(strict_types=1);

namespace App\Teacher\Lesson\Application\CreateLesson;

use App\Shared\Domain\ValueObject\UuidValueObject;
use App\Teacher\Lesson\Domain\Lesson;
use App\Teacher\Lesson\Domain\Teacher;

interface CreateLessonRepository
{
    public function store(Lesson $book): void;

    public function findTeacher(UuidValueObject $id): ?Teacher;
}
