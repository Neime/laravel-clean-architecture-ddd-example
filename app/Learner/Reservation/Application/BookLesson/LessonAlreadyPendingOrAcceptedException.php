<?php

namespace App\Learner\Reservation\Application\BookLesson;

final class LessonAlreadyPendingOrAcceptedException extends \Exception
{
    public function __construct(string $message = '')
    {
        parent::__construct($message ?: 'This lesson is already pending or accepted');
    }
}
