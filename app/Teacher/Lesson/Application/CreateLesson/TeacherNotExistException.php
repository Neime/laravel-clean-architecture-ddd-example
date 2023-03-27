<?php

declare(strict_types=1);

namespace App\Teacher\Lesson\Application\CreateLesson;

final class TeacherNotExistException extends \Exception
{
    public function __construct(string $message = '')
    {
        parent::__construct($message ?: 'This teacher does not exist');
    }
}
