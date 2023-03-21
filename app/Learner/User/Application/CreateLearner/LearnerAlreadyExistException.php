<?php

namespace App\Learner\User\Application\CreateLearner;

final class LearnerAlreadyExistException extends \Exception
{
    public function __construct(string $message = '')
    {
        parent::__construct($message ?: 'This email is already exist');
    }
}
