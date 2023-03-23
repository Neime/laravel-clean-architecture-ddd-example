<?php

declare(strict_types=1);

namespace App\Teacher\User\Infrastructure\Laravel;

use App\Shared\Infrastructure\Eloquent\EloquentUser;
use App\Teacher\User\Application\CreateTeacher\CreateTeacherRepository;
use App\Teacher\User\Domain\Email;
use App\Teacher\User\Domain\HashedPassword;
use App\Teacher\User\Domain\Teacher;

class EloquentTeacherRepository implements CreateTeacherRepository
{
    public function store(Teacher $teacher, HashedPassword $password): void
    {
        $userEloquent = new EloquentUser();
        $userEloquent->id = (string) $teacher->id();
        $userEloquent->type = EloquentUser::TEACHER_TYPE;
        $userEloquent->email = $teacher->email();
        $userEloquent->company_name = $teacher->companyName();
        $userEloquent->firstname = $teacher->firstname();
        $userEloquent->lastname = $teacher->lastname();
        $userEloquent->password = (string) $password;

        $userEloquent->save();
    }

    public function isEmailAlreadyExist(Email $email): bool
    {
        return EloquentUser::where('email', (string) $email)->exists();
    }
}
