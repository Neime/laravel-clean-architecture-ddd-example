<?php

declare(strict_types=1);

namespace App\Bank\Wallet\Application\CreateTransaction;

final class WalletNotExistException extends \Exception
{
    public function __construct(string $message = '')
    {
        parent::__construct($message ?: 'This wallet does not exist');
    }
}
