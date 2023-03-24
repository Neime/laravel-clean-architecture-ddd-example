<?php

namespace App\Teacher\Lesson\Application\RefuseBooking;

final class BookingNotAwaitRefuseException extends \Exception
{
    public function __construct(string $message = '')
    {
        parent::__construct($message ?: 'This booking does not await to refuse');
    }
}
