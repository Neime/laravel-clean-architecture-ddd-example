<?php

declare(strict_types=1);

namespace App\Learner\Reservation\Application\BookLesson;

final class LessonNotExistException extends \Exception
{
    public function __construct(string $message = '')
    {
        parent::__construct($message ?: 'This lesson does not exist');
    }
}
