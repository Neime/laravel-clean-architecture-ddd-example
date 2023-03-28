<?php

declare(strict_types=1);

namespace App\Bank\Wallet\Application\Shared;

final class CurrencyMismatchException extends \Exception
{
    public function __construct(string $message = '')
    {
        parent::__construct($message ?: 'The currency of the wallet and the transaction do not match');
    }
}
