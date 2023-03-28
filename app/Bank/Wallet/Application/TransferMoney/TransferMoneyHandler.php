<?php

declare(strict_types=1);

namespace App\Bank\Wallet\Application\TransferMoney;

use App\Bank\Wallet\Application\Shared\CurrencyMismatchException;
use App\Bank\Wallet\Application\Shared\TransactionRepository;
use App\Bank\Wallet\Application\Shared\WalletNotExistException;
use App\Bank\Wallet\Domain\Credit;
use App\Bank\Wallet\Domain\Currency;
use App\Bank\Wallet\Domain\Debit;
use App\Bank\Wallet\Domain\WalletId;
use App\Shared\Application\CommandHandler;
use App\Shared\Domain\ValueObject\UuidValueObject;

final class TransferMoneyHandler implements CommandHandler
{
    public function __construct(
        private readonly TransactionRepository $transactionRepository,
    ) {
    }

    public function __invoke(TransferMoneyCommand $command): void
    {
        $walletId = new WalletId($command->walletId);
        $toWalletId = new WalletId($command->toWalletId);
        $currency = new Currency($command->currency);

        if (!$this->transactionRepository->walletExist($walletId)) {
            throw new WalletNotExistException();
        }

        if (!$currency->isEqualsTo($this->transactionRepository->currency($walletId))) {
            throw new CurrencyMismatchException();
        }

        if (!$this->transactionRepository->walletExist($toWalletId)) {
            throw new WalletNotExistException();
        }

        if (!$currency->isEqualsTo($this->transactionRepository->currency($toWalletId))) {
            throw new CurrencyMismatchException();
        }

        $debit = Debit::create(
            UuidValueObject::random(),
            $command->amount,
            $currency,
            $walletId,
            $this->transactionRepository->balance($walletId)
        );

        $this->transactionRepository->store($debit->transaction());

        $credit = Credit::create(
            UuidValueObject::random(),
            $command->amount,
            $currency,
            $toWalletId,
            $this->transactionRepository->balance($toWalletId)
        );

        $this->transactionRepository->store($credit->transaction());
    }
}
