<?php

declare(strict_types=1);

namespace App\Bank\Wallet\Application\DebitWallet;

use App\Shared\Application\Command;

final class DebitWalletCommand implements Command
{
    public function __construct(
        public readonly string $id,
        public readonly string $walletId,
        public readonly int $amount,
        public readonly string $currency,
    ) {
    }
}
