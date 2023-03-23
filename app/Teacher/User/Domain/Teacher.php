<?php

declare(strict_types=1);

namespace App\Teacher\User\Domain;

use App\Shared\Domain\ValueObject\UuidValueObject;

final class Teacher
{
    public function __construct(
        private readonly UuidValueObject $id,
        private readonly Email $email,
        private readonly CompanyName $companyName,
        private readonly Firstname $firstname,
        private readonly Lastname $lastname,
    ) {
    }

    public static function create(
        UuidValueObject $id,
        Credentials $credentials,
        CompanyName $companyName,
        Firstname $firstname,
        Lastname $lastname,
    ): self {
        $learner = new self(
            $id,
            $credentials->email,
            $companyName,
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

    public function companyName(): CompanyName
    {
        return $this->companyName;
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
