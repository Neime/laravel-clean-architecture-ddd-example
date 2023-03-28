<?php

namespace Tests\EndToEnd\Bank\Wallet;

use App\Shared\Domain\ValueObject\UuidValueObject;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;
use Tests\WithWallet;

class CreditWalletTest extends TestCase
{
    use WithFaker;
    use WithWallet;

    private string $creditWallerUri;

    protected function setUp(): void
    {
        parent::setUp();
        $this->creditWallerUri = '/api/wallet/%s/credit';
    }

    /** @test **/
    public function canCreditWallet(): void
    {
        $wallet = $this->newWallet();

        $parameters = [
            'amount' => 2000,
            'currency' => 'EUR',
        ];

        $response = $this->postJson(sprintf($this->creditWallerUri, $wallet->id), $parameters);

        $response->assertStatus(Response::HTTP_CREATED);

        $this->assertDatabaseHas('transaction', [
            'id' => $response->json('id'),
            'wallet_id' => $wallet->id,
            'amount' => 2000,
            'currency' => 'EUR',
            'status' => 'completed',
            'description' => 'Money received',
        ]);
    }

    /** @test **/
    public function cannotCreditWalletWithoutWalletId(): void
    {
        $parameters = [
            'amount' => 2000,
            'currency' => 'EUR',
        ];

        $response = $this->postJson(sprintf($this->creditWallerUri, (string) UuidValueObject::random()), $parameters);

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(['error' => 'This wallet does not exist']);
    }

    /** @test **/
    public function cannotCreditWalletWithCurrencyMismatchFromWallet(): void
    {
        $wallet = $this->newWallet(currencyCode: 'USD');

        $parameters = [
            'amount' => 2000,
            'currency' => 'EUR',
        ];

        $response = $this->postJson(sprintf($this->creditWallerUri, $wallet->id), $parameters);

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(['error' => 'The currency of the wallet and the transaction do not match']);
    }
}
