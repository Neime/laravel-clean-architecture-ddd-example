<?php

namespace App\Teacher\User\Application\CreateTeacher;

final class TeacherAlreadyExistException extends \Exception
{
    public function __construct(string $message = '')
    {
        parent::__construct($message ?: 'This email is already exist');
    }
}
