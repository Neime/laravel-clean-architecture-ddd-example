<?php

declare(strict_types=1);

namespace App\Bank\Wallet\Application\TransferMoney;

use App\Shared\Application\Command;

final class TransferMoneyCommand implements Command
{
    public function __construct(
        public readonly string $walletId,
        public readonly string $toWalletId,
        public readonly int $amount,
        public readonly string $currency,
    ) {
    }
}
