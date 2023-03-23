<?php

declare(strict_types=1);

namespace App\Teacher\User\Application\CreateTeacher;

use App\Teacher\User\Domain\Email;
use App\Teacher\User\Domain\HashedPassword;
use App\Teacher\User\Domain\Teacher;

interface CreateTeacherRepository
{
    public function store(Teacher $teacher, HashedPassword $password): void;

    public function isEmailAlreadyExist(Email $email): bool;
}
