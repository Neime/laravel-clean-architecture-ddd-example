<?php

namespace Tests\EndToEnd\Bank\Wallet;

use App\Bank\Wallet\Domain\PaymentStatus;
use App\Shared\Domain\ValueObject\UuidValueObject;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;
use Tests\WithWallet;

class DebitWalletTest extends TestCase
{
    use WithFaker;
    use WithWallet;

    private string $debitWalletUri;

    protected function setUp(): void
    {
        parent::setUp();
        $this->debitWalletUri = '/api/wallet/%s/debit';
    }

    /** @test **/
    public function canDebitWallet(): void
    {
        $wallet = $this->newWallet();

        $parameters = [
            'amount' => 2000,
            'currency' => 'EUR',
        ];

        $response = $this->postJson(sprintf($this->debitWalletUri, $wallet->id), $parameters);

        $response->assertStatus(Response::HTTP_CREATED);

        $this->assertDatabaseHas('transaction', [
            'id' => $response->json('id'),
            'wallet_id' => $wallet->id,
            'amount' => -2000,
            'currency' => 'EUR',
            'status' => 'completed',
            'description' => 'Money received',
        ]);
    }

    /** @test **/
    public function cannotDebitWalletWithoutWalletId(): void
    {
        $parameters = [
            'amount' => 2000,
            'currency' => 'EUR',
        ];

        $response = $this->postJson(sprintf($this->debitWalletUri, (string) UuidValueObject::random()), $parameters);

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(['error' => 'This wallet does not exist']);
    }

    /** @test **/
    public function cannotDebitWalletWithCurrencyMismatchFromWallet(): void
    {
        $wallet = $this->newWallet(currencyCode: 'USD');

        $parameters = [
            'amount' => 2000,
            'currency' => 'EUR',
        ];

        $response = $this->postJson(sprintf($this->debitWalletUri, $wallet->id), $parameters);

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(['error' => 'The currency of the wallet and the transaction do not match']);
    }

    /** @test **/
    public function canDebitWalletWithNotEnoughBalanceMustBeFailed(): void
    {
        $wallet = $this->newWallet(balance: 1000);

        $parameters = [
            'amount' => 2000,
            'currency' => 'EUR',
        ];

        $response = $this->postJson(sprintf($this->debitWalletUri, $wallet->id), $parameters);

        $response->assertStatus(Response::HTTP_CREATED);

        $this->assertDatabaseHas('transaction', [
            'id' => $response->json('id'),
            'wallet_id' => $wallet->id,
            'amount' => -2000,
            'currency' => 'EUR',
            'status' => 'failed',
            'description' => 'Insufficient funds, the balance is 1000',
        ]);
    }

    /** @test **/
    public function canDebitWalletFailedWithTransactionsOnBalance(): void
    {
        $wallet = $this->newWallet(balance: 1000);
        $this->newTransaction($wallet, 1000, status: PaymentStatus::FAILED->value);
        $this->newTransaction($wallet, 2000, status: PaymentStatus::NEW->value);
        $this->newTransaction($wallet, 500, status: PaymentStatus::COMPLETED->value);

        $parameters = [
            'amount' => 2000,
            'currency' => 'EUR',
        ];

        $response = $this->postJson(sprintf($this->debitWalletUri, $wallet->id), $parameters);

        $response->assertStatus(Response::HTTP_CREATED);

        $this->assertDatabaseHas('transaction', [
            'id' => $response->json('id'),
            'wallet_id' => $wallet->id,
            'amount' => -2000,
            'currency' => 'EUR',
            'status' => 'failed',
            'description' => 'Insufficient funds, the balance is 1500',
        ]);
    }
}
