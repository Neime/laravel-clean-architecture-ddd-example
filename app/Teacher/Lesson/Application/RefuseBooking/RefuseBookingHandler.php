<?php

declare(strict_types=1);

namespace App\Teacher\Lesson\Application\RefuseBooking;

use App\Shared\Application\CommandHandler;
use App\Shared\Domain\ValueObject\UuidValueObject;
use App\Teacher\Lesson\Application\Shared\BookingNotExistException;
use App\Teacher\Lesson\Application\Shared\ValidationStateBookingRepository;
use App\Teacher\Lesson\Domain\ValidationState;

final class RefuseBookingHandler implements CommandHandler
{
    public function __construct(
        private readonly ValidationStateBookingRepository $validationStateBookingRepository,
    ) {
    }

    public function __invoke(RefuseBookingCommand $command): void
    {
        $id = new UuidValueObject($command->id);
        $validationState = ValidationState::tryFrom($command->validationState);

        $booking = $this->validationStateBookingRepository->find($id);
        if (null === $booking) {
            throw new BookingNotExistException();
        }

        if (ValidationState::PENDING !== $booking->validationState() || !$booking->isPaymentValid()->value) {
            throw new BookingNotAwaitRefuseException();
        }

        if (ValidationState::REFUSED === $validationState) {
            $this->validationStateBookingRepository->refuse($booking);
        }
    }
}
