<?php

namespace App\Teacher\Lesson\Application\AccepteBooking;

final class BookingNotAwaitAccepteException extends \Exception
{
    public function __construct(string $message = '')
    {
        parent::__construct($message ?: 'This booking does not wait to be validated');
    }
}
