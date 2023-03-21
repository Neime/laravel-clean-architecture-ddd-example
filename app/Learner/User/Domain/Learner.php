<?php

declare(strict_types=1);

namespace App\Learner\User\Domain;

use App\Shared\Domain\ValueObject\UuidValueObject;

final class Learner
{
    public function __construct(
        private readonly UuidValueObject $id,
        private readonly Email $email,
        private readonly Firstname $firstname,
        private readonly Lastname $lastname,
    ) {
    }
    public static function create(
        UuidValueObject $id,
        Credentials $credentials,
        Firstname $firstname,
        Lastname $lastname,
    ): self {
        $learner = new self(
            $id,
            $credentials->email,
            $firstname,
            $lastname,
        );

        return $learner;
    }

    public function id(): UuidValueObject
    {
        return $this->id;
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function firstname(): Firstname
    {
        return $this->firstname;
    }

    public function lastname(): Lastname
    {
        return $this->lastname;
    }
}
