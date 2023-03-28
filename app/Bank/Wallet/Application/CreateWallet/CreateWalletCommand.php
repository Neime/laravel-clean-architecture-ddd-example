<?php

declare(strict_types=1);

namespace App\Bank\Wallet\Application\CreateWallet;

use App\Shared\Application\Command;

final class CreateWalletCommand implements Command
{
    public function __construct(
        public readonly string $id,
        public readonly string $userId,
        public readonly string $currency,
    ) {
    }
}
