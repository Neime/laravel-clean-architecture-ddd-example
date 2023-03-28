<?php

declare(strict_types=1);

namespace App\Bank\Wallet\Application\CreditWallet;

use App\Bank\Wallet\Application\Shared\CurrencyMismatchException;
use App\Bank\Wallet\Application\Shared\TransactionRepository;
use App\Bank\Wallet\Application\Shared\WalletNotExistException;
use App\Bank\Wallet\Domain\Credit;
use App\Bank\Wallet\Domain\Currency;
use App\Bank\Wallet\Domain\WalletId;
use App\Shared\Application\CommandHandler;
use App\Shared\Domain\ValueObject\UuidValueObject;

final class CreditWalletHandler implements CommandHandler
{
    public function __construct(
        private readonly TransactionRepository $transactionRepository,
    ) {
    }

    public function __invoke(CreditWalletCommand $command): void
    {
        $id = new UuidValueObject($command->id);
        $currency = new Currency($command->currency);
        $walletId = new WalletId($command->walletId);

        if (!$this->transactionRepository->walletExist($walletId)) {
            throw new WalletNotExistException();
        }

        if (!$currency->isEqualsTo($this->transactionRepository->currency($walletId))) {
            throw new CurrencyMismatchException();
        }

        $credit = Credit::create(
            $id,
            $command->amount,
            $currency,
            $walletId,
        );

        $this->transactionRepository->store($credit->transaction());
    }
}
