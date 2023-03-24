<?php

namespace App\Teacher\Lesson\Application\ValidateBooking;

final class BookingNotAwaitValidationException extends \Exception
{
    public function __construct(string $message = '')
    {
        parent::__construct($message ?: 'This booking does not await validation');
    }
}
