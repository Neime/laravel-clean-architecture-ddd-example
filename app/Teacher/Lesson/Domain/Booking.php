<?php

declare(strict_types=1);

namespace App\Teacher\Lesson\Domain;

use App\Shared\Domain\ValueObject\UuidValueObject;

final class Booking
{
    public function __construct(
        private readonly UuidValueObject $id,
        private readonly ValidationState $validationState,
        private readonly IsPaymentValid $isPaymentValid,
    ) {
    }

    public function id(): UuidValueObject
    {
        return $this->id;
    }

    public function validationState(): ValidationState
    {
        return $this->validationState;
    }

    public function isPaymentValid(): IsPaymentValid
    {
        return $this->isPaymentValid;
    }
}
