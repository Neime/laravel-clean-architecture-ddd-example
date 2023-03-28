<?php

declare(strict_types=1);

namespace App\Bank\Wallet\Application\CreateTransaction;

use App\Bank\Wallet\Domain\Price;
use App\Bank\Wallet\Domain\Transaction;
use App\Bank\Wallet\Domain\WalletId;
use App\Shared\Application\CommandHandler;
use App\Shared\Domain\ValueObject\UuidValueObject;

final class CreateTransactionHandler implements CommandHandler
{
    public function __construct(
        private readonly CreateTransactionRepository $createTransactionRepository,
    ) {
    }

    public function __invoke(CreateTransactionCommand $command): void
    {
        $id = new UuidValueObject($command->id);
        $walletId = new WalletId($command->walletId);
        if (!$this->createTransactionRepository->walletExist($walletId)) {
            throw new WalletNotExistException();
        }

        $price = new Price($command->amount, $command->currency);

        $transaction = Transaction::create($id, $walletId, $price);

        $this->createTransactionRepository->store($transaction);
    }
}
