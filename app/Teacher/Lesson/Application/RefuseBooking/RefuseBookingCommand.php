<?php

declare(strict_types=1);

namespace App\Teacher\Lesson\Application\RefuseBooking;

use App\Shared\Application\Command;

final class RefuseBookingCommand implements Command
{
    public function __construct(
        public readonly string $id,
        public readonly string $validationState,
    ) {
    }
}
