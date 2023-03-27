<?php

declare(strict_types=1);

namespace App\Teacher\Lesson\Application\Shared;

final class BookingNotExistException extends \Exception
{
    public function __construct(string $message = '')
    {
        parent::__construct($message ?: 'This booking does not exist');
    }
}
