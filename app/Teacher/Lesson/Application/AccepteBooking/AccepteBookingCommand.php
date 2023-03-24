<?php

declare(strict_types=1);

namespace App\Teacher\Lesson\Application\AccepteBooking;

use App\Shared\Application\Command;

final class AccepteBookingCommand implements Command
{
    public function __construct(
        public readonly string $id,
        public readonly string $validationState,
    ) {
    }
}
