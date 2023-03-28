<?php

namespace Tests;

use App\Bank\Wallet\Domain\Currency;
use App\Bank\Wallet\Domain\PaymentStatus;
use App\Bank\Wallet\Infrastructure\Laravel\EloquentTransaction;
use App\Bank\Wallet\Infrastructure\Laravel\EloquentWallet;
use Illuminate\Foundation\Testing\WithFaker;

trait WithWallet
{
    use WithFaker;
    use WithLearner;

    protected function newWallet(string $currencyCode = Currency::EUR, ?int $balance = 10000): EloquentWallet
    {
        $learner = $this->newLearner();

        $wallet = new EloquentWallet();
        $wallet->user_id = $learner->id;
        $wallet->currency = $currencyCode ?? $this->faker->currencyCode;
        $wallet->save();

        $this->newTransaction($wallet, $balance);

        return $wallet;
    }

    protected function newTransaction(
        EloquentWallet $wallet,
        int $amount,
        string $currencyCode = null,
        string $status = null,
        string $description = null
    ): EloquentTransaction {
        $transaction = new EloquentTransaction();
        $transaction->wallet_id = $wallet->id;
        $transaction->amount = $amount;
        $transaction->currency = $currencyCode ?? $wallet->currency;
        $transaction->status = $status ?? PaymentStatus::COMPLETED;
        $transaction->description = $description ?? PaymentStatus::COMPLETED->description();

        $transaction->save();

        return $transaction;
    }
}
