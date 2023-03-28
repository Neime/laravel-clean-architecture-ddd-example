<?php

declare(strict_types=1);

namespace App\Bank\Wallet\Application\CreateWallet;

final class WalletAlreadyExistException extends \Exception
{
    public function __construct(string $message = '')
    {
        parent::__construct($message ?: 'There is already a wallet for this user with this currency');
    }
}
