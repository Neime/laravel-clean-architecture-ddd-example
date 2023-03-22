<?php

namespace Tests\EndToEnd\Learner\Reservation;

use App\Learner\Reservation\Domain\AcceptationState;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;
use Tests\WithBooks;
use Tests\WithLearner;

class GetBookingsTest extends TestCase
{
    use WithFaker;
    use WithBooks;
    use WithLearner;

    private string $getBookingsUri;

    protected function setUp(): void
    {
        parent::setUp();
        $this->getBookingsUri = '/api/bookings/%s';
    }

    /** @test **/
    public function getBookingsPendingAndAcceptedByLearner(): void
    {
        $learner1 = $this->newLearner();
        $learner2 = $this->newLearner();

        $numberPendingBooksLearner1 = $this->faker->numberBetween(1, 5);
        $numberPendingBooksLearner2 = $this->faker->numberBetween(1, 5);

        $numberAcceptedBooksLearner1 = $this->faker->numberBetween(1, 5);
        $numberAcceptedBooksLearner2 = $this->faker->numberBetween(1, 5);

        $numberRefusedBooksLearner1 = $this->faker->numberBetween(1, 5);
        $numberRefusedBooksLearner2 = $this->faker->numberBetween(1, 5);

        $this->createRandomBooks($numberPendingBooksLearner1, $learner1, AcceptationState::PENDING);
        $this->createRandomBooks($numberPendingBooksLearner2, $learner2, AcceptationState::PENDING);

        $this->createRandomBooks($numberAcceptedBooksLearner1, $learner1, AcceptationState::ACCEPTED);
        $this->createRandomBooks($numberAcceptedBooksLearner2, $learner2, AcceptationState::ACCEPTED);

        $this->createRandomBooks($numberRefusedBooksLearner1, $learner1, AcceptationState::REFUSED);
        $this->createRandomBooks($numberRefusedBooksLearner2, $learner2, AcceptationState::REFUSED);

        $response = $this->getJson(sprintf($this->getBookingsUri, $learner1->id));

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount($numberPendingBooksLearner1 + $numberAcceptedBooksLearner1);
    }
}
