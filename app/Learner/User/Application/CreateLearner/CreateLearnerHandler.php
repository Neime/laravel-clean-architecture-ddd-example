<?php

declare(strict_types=1);

namespace App\Learner\User\Application\CreateLearner;

use App\Learner\User\Domain\Credentials;
use App\Learner\User\Domain\Email;
use App\Learner\User\Domain\Firstname;
use App\Learner\User\Domain\HashedPassword;
use App\Learner\User\Domain\Lastname;
use App\Learner\User\Domain\Learner;
use App\Shared\Application\CommandHandler;
use App\Shared\Domain\ValueObject\UuidValueObject;

final class CreateLearnerHandler implements CommandHandler
{
    public function __construct(
        private readonly CreateLearnerRepository $createLearnerRepository,
    ) {
    }

    public function __invoke(CreateLearnerCommand $command): void
    {
        $id = new UuidValueObject($command->id);
        $firstname = new Firstname($command->firstname);
        $lastname = new Lastname($command->lastname);
        $email = new Email($command->email);

        if ($this->createLearnerRepository->isEmailAlreadyExist($email)) {
            throw new LearnerAlreadyExistException();
        }

        $hashedPassword = HashedPassword::encode($command->password);
        $credentials = new Credentials($email, $hashedPassword);

        $learner = Learner::create($id, $credentials, $firstname, $lastname);

        $this->createLearnerRepository->store($learner, $hashedPassword);
    }
}
