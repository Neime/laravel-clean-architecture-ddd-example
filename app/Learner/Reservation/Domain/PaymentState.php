<?php

declare(strict_types=1);

namespace App\Learner\Reservation\Domain;

enum PaymentState: string
{
    case NEW = 'new';
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case REFUSED = 'refused';
}
