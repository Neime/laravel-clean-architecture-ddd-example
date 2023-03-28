<?php

declare(strict_types=1);

namespace App\Bank\Wallet\Domain;

use App\Learner\Reservation\Domain\PaymentState;
use App\Shared\Domain\ValueObject\UuidValueObject;

final class Transaction
{
    public function __construct(
        private readonly UuidValueObject $id,
        private readonly WalletId $walletId,
        private readonly Price $price,
        private readonly PaymentState $paymentState,
    ) {
    }

    public static function create(UuidValueObject $id, WalletId $walletId, Price $price): self
    {
        return new self($id, $walletId, $price, PaymentState::NEW);
    }

    public function id(): UuidValueObject
    {
        return $this->id;
    }

    public function walletId(): WalletId
    {
        return $this->walletId;
    }

    public function price(): Price
    {
        return $this->price;
    }

    public function paymentState(): PaymentState
    {
        return $this->paymentState;
    }
}
