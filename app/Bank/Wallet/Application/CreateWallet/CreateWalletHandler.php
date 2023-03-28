<?php

declare(strict_types=1);

namespace App\Bank\Wallet\Application\CreateWallet;

use App\Bank\Wallet\Domain\Currency;
use App\Bank\Wallet\Domain\UserId;
use App\Bank\Wallet\Domain\Wallet;
use App\Bank\Wallet\Domain\WalletId;
use App\Shared\Application\CommandHandler;

final class CreateWalletHandler implements CommandHandler
{
    public function __construct(
        private readonly CreateWalletRepository $createWalletRepository,
    ) {
    }

    public function __invoke(CreateWalletCommand $command): void
    {
        $id = new WalletId($command->id);
        $currency = new Currency($command->currency);
        $userId = new UserId($command->userId);

        if (!$this->createWalletRepository->userExist($userId)) {
            throw new UserNotExistException();
        }

        if ($this->createWalletRepository->walletAlreadyExist($userId, $currency)) {
            throw new WalletAlreadyExistException();
        }

        $transaction = Wallet::create(
            $id,
            $userId,
            $currency,
        );

        $this->createWalletRepository->store($transaction);
    }
}
