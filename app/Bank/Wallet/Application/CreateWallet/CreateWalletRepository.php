<?php

declare(strict_types=1);

namespace App\Bank\Wallet\Application\CreateWallet;

use App\Bank\Wallet\Domain\Currency;
use App\Bank\Wallet\Domain\UserId;
use App\Bank\Wallet\Domain\Wallet;

interface CreateWalletRepository
{
    public function userExist(UserId $userId): bool;

    public function walletAlreadyExist(UserId $userId, Currency $currency): bool;

    public function store(Wallet $wallet): void;
}
