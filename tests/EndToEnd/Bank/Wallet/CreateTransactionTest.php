<?php

namespace Tests\EndToEnd\Bank\Wallet;

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
            'wallet_id' => $wallet->id,
            'amount' => 2000,
            'currency' => 'EUR',
            'status' => 'new',
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
}
