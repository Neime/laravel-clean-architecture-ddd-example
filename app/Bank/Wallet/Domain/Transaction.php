<?php

declare(strict_types=1);

namespace App\Bank\Wallet\Domain;

use App\Shared\Domain\ValueObject\UuidValueObject;

final class Transaction
{
    public function __construct(
        private readonly UuidValueObject $id,
        private readonly WalletId $walletId,
        private readonly Price $price,
        private readonly PaymentInstructions $paymentInstructions,
    ) {
    }

    public static function create(UuidValueObject $id, Price $price, WalletId $walletId, Balance $walletBalance): self
    {
        $paymentInstructions = PaymentInstructions::create();

        if ($walletBalance->value < $price->amount()) {
            $paymentInstructions = PaymentInstructions::fail(
                sprintf('Insufficient funds, the balance is %s', $walletBalance->value)
            );
        }

        return new self($id, $walletId, $price, $paymentInstructions);
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

    public function paymentInstructions(): PaymentInstructions
    {
        return $this->paymentInstructions;
    }

    public function paymentState(): string
    {
        return $this->paymentInstructions->status()->value;
    }

    public function paymentDescription(): string
    {
        return $this->paymentInstructions->description();
    }
}
