<?php

declare(strict_types=1);

namespace App\Bank\Wallet\Infrastructure\Laravel;

use App\Bank\Wallet\Application\CreateTransaction\CreateTransactionRepository;
use App\Bank\Wallet\Application\CreateWallet\CreateWalletRepository;
use Illuminate\Support\ServiceProvider;

class WalletServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(CreateTransactionRepository::class, EloquentTransactionRepository::class);
        $this->app->bind(CreateWalletRepository::class, EloquentWalletRepository::class);
    }
}
