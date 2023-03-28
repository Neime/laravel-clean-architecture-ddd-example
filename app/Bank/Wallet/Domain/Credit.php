<?php

declare(strict_types=1);

namespace App\Bank\Wallet\Domain;

use App\Shared\Domain\ValueObject\UuidValueObject;

final class Credit
{
    public function __construct(
        private readonly Transaction $transaction,
    ) {
    }

    public static function create(UuidValueObject $id, int $amount, Currency $currency, WalletId $walletId): self
    {
        $price = new Price($amount, $currency);
        $transaction = Transaction::create($id, $price, $walletId);
        $transactionCompleted = Transaction::complete($transaction);

        return new self($transactionCompleted);
    }

    public function transaction(): Transaction
    {
        return $this->transaction;
    }
}
