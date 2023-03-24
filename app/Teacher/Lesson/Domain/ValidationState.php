<?php

declare(strict_types=1);

namespace App\Teacher\Lesson\Domain;

enum ValidationState: string
{
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case REFUSED = 'refused';
}
