<?php

namespace Tests\EndToEnd\Bank\Wallet;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;
use Tests\WithWallet;

class TransferMoneyTest extends TestCase
{
    use WithFaker;
    use WithWallet;

    private string $transferMoneyUri;

    protected function setUp(): void
    {
        parent::setUp();
        $this->transferMoneyUri = '/api/transfer/wallet_id/to/to_wallet_id';
    }

    /** @test **/
    public function canCreateTransaction(): void
    {
        $wallet = $this->newWallet();
        $toWallet = $this->newWallet(balance: 0);

        $parameters = [
            'amount' => 2000,
            'currency' => 'EUR',
        ];

        $response = $this->postJson(
            strtr($this->transferMoneyUri, ['wallet_id' => $wallet->id, 'to_wallet_id' => $toWallet->id]),
            $parameters
        );

        $response->assertStatus(Response::HTTP_CREATED);

        $this->assertDatabaseHas('transaction', [
            'wallet_id' => $wallet->id,
            'amount' => -2000,
            'currency' => 'EUR',
            'status' => 'completed',
        ]);

        $this->assertDatabaseHas('transaction', [
            'wallet_id' => $toWallet->id,
            'amount' => 2000,
            'currency' => 'EUR',
            'status' => 'completed',
        ]);
    }
}
