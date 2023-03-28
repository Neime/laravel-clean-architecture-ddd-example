<?php

declare(strict_types=1);

namespace App\Bank\Wallet\Domain;

use App\Shared\Domain\ValueObject\UuidValueObject;

final class Debit
{
    public function __construct(
        private readonly Transaction $transaction,
    ) {
    }

    public static function create(UuidValueObject $id, int $amount, Currency $currency, WalletId $walletId, Balance $walletBalance): self
    {
        $price = new Price(-$amount, $currency);
        $transaction = Transaction::create($id, $price, $walletId);

        if ($walletBalance->value < $amount) {
            return new self(Transaction::fail($transaction, sprintf('Insufficient funds, the balance is %s', $walletBalance->value)));
        }

        return new self(Transaction::complete($transaction));
    }

    public function transaction(): Transaction
    {
        return $this->transaction;
    }
}
