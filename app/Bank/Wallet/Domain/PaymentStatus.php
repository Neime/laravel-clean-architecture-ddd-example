<?php

declare(strict_types=1);

namespace App\Bank\Wallet\Domain;

enum PaymentStatus: string
{
    case NEW = 'new';
    case PENDING = 'pending';
    case COMPLETED = 'completed';
    case FAILED = 'failed';
}
