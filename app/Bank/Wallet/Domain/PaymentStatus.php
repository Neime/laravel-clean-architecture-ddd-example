<?php

declare(strict_types=1);

namespace App\Bank\Wallet\Domain;

enum PaymentStatus: string
{
    case NEW = 'new';
    case PENDING = 'pending';
    case COMPLETED = 'completed';
    case FAILED = 'failed';

    public function description(): string
    {
        return match ($this) {
            self::NEW => 'Transaction created',
            self::PENDING => 'Transaction validated',
            self::COMPLETED => 'Money received',
            self::FAILED => 'Transaction failed',
        };
    }
}
