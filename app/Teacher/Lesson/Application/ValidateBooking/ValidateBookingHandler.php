<?php

declare(strict_types=1);

namespace App\Teacher\Lesson\Application\ValidateBooking;

use App\Shared\Application\CommandHandler;
use App\Shared\Domain\ValueObject\UuidValueObject;
use App\Teacher\Lesson\Domain\ValidationState;

final class ValidateBookingHandler implements CommandHandler
{
    public function __construct(
        private readonly ValidateBookingRepository $validateBookingRepository,
    ) {
    }

    public function __invoke(ValidateBookingCommand $command): void
    {
        $id = new UuidValueObject($command->id);

        $booking = $this->validateBookingRepository->find($id);
        if (null === $booking) {
            throw new BookingNotExistException();
        }

        if (ValidationState::PENDING !== $booking->validationState()) {
            throw new BookingNotAwaitValidationException();
        }

        $this->validateBookingRepository->validate($booking);
    }
}
