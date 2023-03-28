<?php

namespace Tests\EndToEnd\Bank\Wallet;

use App\Shared\Domain\ValueObject\UuidValueObject;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;
use Tests\WithLearner;

class CreateWalletTest extends TestCase
{
    use WithFaker;
    use WithLearner;

    private string $createWalletUri;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createWalletUri = '/api/wallet';
    }

    /** @test **/
    public function canCreateWallet(): void
    {
        $learner = $this->newLearner();

        $parameters = [
            'user_id' => $learner->id,
            'currency' => 'EUR',
        ];

        $response = $this->postJson($this->createWalletUri, $parameters);

        $response->assertStatus(Response::HTTP_CREATED);

        // Asset cannot create wallet with same user and currency
        $response = $this->postJson($this->createWalletUri, $parameters);
        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(['error' => 'There is already a wallet for this user with this currency']);

        $this->assertDatabaseHas('wallet', [
            'user_id' => $learner->id,
            'currency' => 'EUR',
        ]);
    }

    /** @test **/
    public function cannotCreateWalletWithoutExistingUser(): void
    {
        $parameters = [
            'user_id' => (string) UuidValueObject::random(),
            'currency' => 'EUR',
        ];

        $response = $this->postJson($this->createWalletUri, $parameters);

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(['error' => 'This user does not exist']);
    }
}
