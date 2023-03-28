<?php

declare(strict_types=1);

namespace App\Bank\Wallet\Domain;

final class Wallet
{
    private array $transactions = [];

    public function __construct(
        private readonly WalletId $walletId,
        private readonly UserId $userId,
        private readonly Currency $currency,
    ) {
    }

    public static function create(WalletId $id, UserId $userId, Currency $currency): self
    {
        return new self($id, $userId, $currency);
    }

    public function id(): WalletId
    {
        return $this->walletId;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function currency(): Currency
    {
        return $this->currency;
    }
}
