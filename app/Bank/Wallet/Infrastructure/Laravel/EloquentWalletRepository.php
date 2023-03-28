<?php

declare(strict_types=1);

namespace App\Bank\Wallet\Infrastructure\Laravel;

use App\Bank\Wallet\Application\CreateWallet\CreateWalletRepository;
use App\Bank\Wallet\Domain\Currency;
use App\Bank\Wallet\Domain\UserId;
use App\Bank\Wallet\Domain\Wallet;
use App\Shared\Infrastructure\Eloquent\EloquentUser;

class EloquentWalletRepository implements CreateWalletRepository
{
    public function userExist(UserId $userId): bool
    {
        return EloquentUser::where('id', (string) $userId)->exists();
    }

    public function walletAlreadyExist(UserId $userId, Currency $currency): bool
    {
        return EloquentWallet::where('user_id', (string) $userId)->where('currency', (string) $currency)->exists();
    }

    public function store(Wallet $wallet): void
    {
        $walletEloquent = new EloquentWallet();
        $walletEloquent->id = (string) $wallet->id();
        $walletEloquent->user_id = (string) $wallet->userId();
        $walletEloquent->currency = (string) $wallet->currency();

        $walletEloquent->save();
    }
}
