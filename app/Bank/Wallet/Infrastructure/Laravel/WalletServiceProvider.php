<?php

declare(strict_types=1);

namespace App\Bank\Wallet\Infrastructure\Laravel;

use App\Bank\Wallet\Application\CreateWallet\CreateWalletRepository;
use App\Bank\Wallet\Application\Shared\TransactionRepository;
use Illuminate\Support\ServiceProvider;

class WalletServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(TransactionRepository::class, EloquentTransactionRepository::class);
        $this->app->bind(CreateWalletRepository::class, EloquentWalletRepository::class);
    }
}
