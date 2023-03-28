<?php

declare(strict_types=1);

namespace App\Bank\Wallet\Domain;

final class PaymentInstructions
{
    public function __construct(
        private readonly PaymentStatus $status,
        private readonly string $description,
    ) {
    }

    public function description(): string
    {
        return $this->description;
    }

    public function status(): PaymentStatus
    {
        return $this->status;
    }

    public static function create(): self
    {
        $paymentStatus = PaymentStatus::NEW;

        return new self($paymentStatus, $paymentStatus->description());
    }

    public static function complete(): self
    {
        $paymentStatus = PaymentStatus::COMPLETED;

        return new self($paymentStatus, $paymentStatus->description());
    }

    public static function fail(?string $description = null): self
    {
        $paymentStatus = PaymentStatus::FAILED;

        return new self($paymentStatus, $description ?? $paymentStatus->description());
    }
}
