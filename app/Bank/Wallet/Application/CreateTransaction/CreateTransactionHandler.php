<?php

declare(strict_types=1);

namespace App\Bank\Wallet\Application\CreateTransaction;

use App\Bank\Wallet\Domain\Currency;
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
        $currency = new Currency($command->currency);
        $walletId = new WalletId($command->walletId);

        if (!$this->createTransactionRepository->walletExist($walletId)) {
            throw new WalletNotExistException();
        }

        if (!$currency->isEqualsTo($this->createTransactionRepository->currency($walletId))) {
            throw new CurrencyMismatchException();
        }

        $transaction = Transaction::create(
            $id,
            new Price($command->amount, $currency),
            $walletId,
            $this->createTransactionRepository->balance($walletId)
        );

        $this->createTransactionRepository->store($transaction);
    }
}
