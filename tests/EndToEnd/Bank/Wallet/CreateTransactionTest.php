<?php

namespace Tests\EndToEnd\Bank\Wallet;

use App\Bank\Wallet\Domain\PaymentStatus;
use App\Shared\Domain\ValueObject\UuidValueObject;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;
use Tests\WithWallet;

class CreateTransactionTest extends TestCase
{
    use WithFaker;
    use WithWallet;

    private string $createTransactionUri;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createTransactionUri = '/api/transaction';
    }

    /** @test **/
    public function canCreateTransaction(): void
    {
        $wallet = $this->newWallet();

        $parameters = [
            'wallet_id' => $wallet->id,
            'amount' => 2000,
            'currency' => 'EUR',
        ];

        $response = $this->postJson($this->createTransactionUri, $parameters);

        $response->assertStatus(Response::HTTP_CREATED);

        $this->assertDatabaseHas('transaction', [
            'id' => $response->json('id'),
            'wallet_id' => $wallet->id,
            'amount' => 2000,
            'currency' => 'EUR',
            'status' => 'new',
            'description' => 'Transaction created',
        ]);
    }

    /** @test **/
    public function cannotCreateTransactionWithoutWalletId(): void
    {
        $parameters = [
            'wallet_id' => (string) UuidValueObject::random(),
            'amount' => 2000,
            'currency' => 'EUR',
        ];

        $response = $this->postJson($this->createTransactionUri, $parameters);

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(['error' => 'This wallet does not exist']);
    }

    /** @test **/
    public function cannotCreateTransactionWithCurrencyMismatchFromWallet(): void
    {
        $wallet = $this->newWallet(currencyCode: 'USD');

        $parameters = [
            'wallet_id' => $wallet->id,
            'amount' => 2000,
            'currency' => 'EUR',
        ];

        $response = $this->postJson($this->createTransactionUri, $parameters);

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(['error' => 'The currency of the wallet and the transaction do not match']);
    }

    /** @test **/
    public function canCreateTransactionWithNotEnoughBalanceMustBeFailed(): void
    {
        $wallet = $this->newWallet(balance: 1000);

        $parameters = [
            'wallet_id' => $wallet->id,
            'amount' => 2000,
            'currency' => 'EUR',
        ];

        $response = $this->postJson($this->createTransactionUri, $parameters);

        $response->assertStatus(Response::HTTP_CREATED);

        $this->assertDatabaseHas('transaction', [
            'id' => $response->json('id'),
            'wallet_id' => $wallet->id,
            'amount' => 2000,
            'currency' => 'EUR',
            'status' => 'failed',
            'description' => 'Insufficient funds, the balance is 1000',
        ]);
    }

    /** @test **/
    public function canCreateTransactionFailedWithTransactionsOnBalance(): void
    {
        $wallet = $this->newWallet(balance: 1000);
        $this->newTransaction($wallet, 1000, status: PaymentStatus::FAILED->value);
        $this->newTransaction($wallet, 2000, status: PaymentStatus::NEW->value);
        $this->newTransaction($wallet, 500, status: PaymentStatus::COMPLETED->value);

        $parameters = [
            'wallet_id' => $wallet->id,
            'amount' => 2000,
            'currency' => 'EUR',
        ];

        $response = $this->postJson($this->createTransactionUri, $parameters);

        $response->assertStatus(Response::HTTP_CREATED);

        $this->assertDatabaseHas('transaction', [
            'id' => $response->json('id'),
            'wallet_id' => $wallet->id,
            'amount' => 2000,
            'currency' => 'EUR',
            'status' => 'failed',
            'description' => 'Insufficient funds, the balance is 1500',
        ]);
    }
}
