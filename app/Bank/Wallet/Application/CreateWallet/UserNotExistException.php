<?php

declare(strict_types=1);

namespace App\Bank\Wallet\Application\CreateWallet;

final class UserNotExistException extends \Exception
{
    public function __construct(string $message = '')
    {
        parent::__construct($message ?: 'This user does not exist');
    }
}
