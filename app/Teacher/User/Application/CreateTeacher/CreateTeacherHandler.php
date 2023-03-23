<?php

declare(strict_types=1);

namespace App\Teacher\User\Application\CreateTeacher;

use App\Shared\Application\CommandHandler;
use App\Shared\Domain\ValueObject\UuidValueObject;
use App\Teacher\User\Domain\CompanyName;
use App\Teacher\User\Domain\Credentials;
use App\Teacher\User\Domain\Email;
use App\Teacher\User\Domain\Firstname;
use App\Teacher\User\Domain\HashedPassword;
use App\Teacher\User\Domain\Lastname;
use App\Teacher\User\Domain\Teacher;

final class CreateTeacherHandler implements CommandHandler
{
    public function __construct(
        private readonly CreateTeacherRepository $createTeacherRepository,
    ) {
    }

    public function __invoke(CreateTeacherCommand $command): void
    {
        $id = new UuidValueObject($command->id);
        $companyName = new CompanyName($command->companyName);
        $firstname = new Firstname($command->firstname);
        $lastname = new Lastname($command->lastname);
        $email = new Email($command->email);

        if ($this->createTeacherRepository->isEmailAlreadyExist($email)) {
            throw new TeacherAlreadyExistException();
        }

        $hashedPassword = HashedPassword::encode($command->password);
        $credentials = new Credentials($email, $hashedPassword);

        $teacher = Teacher::create($id, $credentials, $companyName, $firstname, $lastname);

        $this->createTeacherRepository->store($teacher, $hashedPassword);
    }
}
