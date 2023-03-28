<?php

declare(strict_types=1);

namespace App\Bank\Wallet\Application\CreateTransaction;

use App\Bank\Wallet\Domain\Transaction;
use App\Bank\Wallet\Domain\WalletId;

interface CreateTransactionRepository
{
    public function walletExist(WalletId $walletId): bool;

    public function store(Transaction $transaction): void;
}
