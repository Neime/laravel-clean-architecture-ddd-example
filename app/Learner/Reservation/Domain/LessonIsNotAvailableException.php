<?php

declare(strict_types=1);

namespace App\Learner\Reservation\Domain;

final class LessonIsNotAvailableException extends \Exception
{
    public function __construct(string $message = '')
    {
        parent::__construct($message ?: 'This lesson is not available');
    }
}
