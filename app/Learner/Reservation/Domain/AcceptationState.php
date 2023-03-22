<?php

declare(strict_types=1);

namespace App\Learner\Reservation\Domain;

enum AcceptationState: string
{
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case REFUSED = 'refused';
}
