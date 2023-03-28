<?php

declare(strict_types=1);

namespace App\Bank\Wallet\Infrastructure\Laravel;

use App\Bank\Wallet\Application\CreateTransaction\CreateTransactionRepository;
use App\Bank\Wallet\Domain\Transaction;
use App\Bank\Wallet\Domain\WalletId;

class EloquentWalletRepository implements CreateTransactionRepository
{
    public function walletExist(WalletId $walletId): bool
    {
        return EloquentWallet::where('id', (string) $walletId)->exists();
    }

    public function store(Transaction $transaction): void
    {
        $transactionEloquent = new EloquentTransaction();
        $transactionEloquent->id = (string) $transaction->id();
        $transactionEloquent->wallet_id = (string) $transaction->walletId();
        $transactionEloquent->amount = $transaction->price()->amount();
        $transactionEloquent->currency = $transaction->price()->currency();
        $transactionEloquent->status = $transaction->paymentState()->value;

        $transactionEloquent->save();
    }
}
