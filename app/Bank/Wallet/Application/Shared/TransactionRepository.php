<?php

declare(strict_types=1);

namespace App\Bank\Wallet\Application\Shared;

use App\Bank\Wallet\Domain\Balance;
use App\Bank\Wallet\Domain\Currency;
use App\Bank\Wallet\Domain\Transaction;
use App\Bank\Wallet\Domain\WalletId;

interface TransactionRepository
{
    public function walletExist(WalletId $walletId): bool;

    public function currency(WalletId $walletId): Currency;

    public function balance(WalletId $walletId): Balance;

    public function store(Transaction $transaction): void;
}
