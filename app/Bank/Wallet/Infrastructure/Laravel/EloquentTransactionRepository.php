<?php

declare(strict_types=1);

namespace App\Bank\Wallet\Infrastructure\Laravel;

use App\Bank\Wallet\Application\CreateTransaction\CreateTransactionRepository;
use App\Bank\Wallet\Domain\Balance;
use App\Bank\Wallet\Domain\Currency;
use App\Bank\Wallet\Domain\PaymentStatus;
use App\Bank\Wallet\Domain\Transaction;
use App\Bank\Wallet\Domain\WalletId;

class EloquentTransactionRepository implements CreateTransactionRepository
{
    public function walletExist(WalletId $walletId): bool
    {
        return EloquentWallet::where('id', (string) $walletId)->exists();
    }

    public function balance(WalletId $walletId): Balance
    {
        return new Balance((int) EloquentTransaction::where('wallet_id', (string) $walletId)->where('status', PaymentStatus::COMPLETED)->sum('amount'));
    }

    public function currency(WalletId $walletId): Currency
    {
        return new Currency((string) EloquentWallet::find((string) $walletId)->currency);
    }

    public function store(Transaction $transaction): void
    {
        $transactionEloquent = new EloquentTransaction();
        $transactionEloquent->id = (string) $transaction->id();
        $transactionEloquent->wallet_id = (string) $transaction->walletId();
        $transactionEloquent->amount = $transaction->price()->amount();
        $transactionEloquent->currency = (string) $transaction->price()->currency();
        $transactionEloquent->status = $transaction->paymentState();
        $transactionEloquent->description = $transaction->paymentDescription();

        $transactionEloquent->save();
    }
}
