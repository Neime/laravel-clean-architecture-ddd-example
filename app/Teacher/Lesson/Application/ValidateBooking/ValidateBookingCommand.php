<?php

declare(strict_types=1);

namespace App\Teacher\Lesson\Application\ValidateBooking;

use App\Shared\Application\Command;

final class ValidateBookingCommand implements Command
{
    public function __construct(
        public readonly string $id,
    ) {
    }
}
