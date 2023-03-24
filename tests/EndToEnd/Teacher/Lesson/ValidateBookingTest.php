<?php

namespace Tests\EndToEnd\Teacher\Lesson;

use App\Learner\Reservation\Domain\ValidationState;
use App\Shared\Domain\ValueObject\UuidValueObject;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;
use Tests\WithBookings;
use Tests\WithLearner;
use Tests\WithLessons;

class ValidateBookingTest extends TestCase
{
    use WithFaker;
    use WithLessons;
    use WithBookings;
    use WithLearner;

    private string $validateBookingUri;

    protected function setUp(): void
    {
        parent::setUp();
        $this->validateBookingUri = '/api/booking/%s/validate';
    }

    /** @test **/
    public function canValidateBooking(): void
    {
        $booking = $this->newBook($this->newLearner(), ValidationState::PENDING);

        $response = $this->postJson(sprintf($this->validateBookingUri, $booking->id));

        $response->assertStatus(Response::HTTP_CREATED);

        $this->assertDatabaseHas('book', ['id' => $booking->id, 'status' => 'accepted']);
    }

    /** @test **/
    public function cannotValidateBookingNotExist(): void
    {
        $response = $this->postJson(sprintf($this->validateBookingUri, UuidValueObject::random()));

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(['error' => 'This booking does not exist']);
    }

    /** @test **/
    public function cannotValidateBookingIsNotPending(): void
    {
        $booking = $this->newBook($this->newLearner(), ValidationState::ACCEPTED);

        $response = $this->postJson(sprintf($this->validateBookingUri, $booking->id));

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(['error' => 'This booking does not await validation']);

        $booking = $this->newBook($this->newLearner(), ValidationState::REFUSED);

        $response = $this->postJson(sprintf($this->validateBookingUri, $booking->id));

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(['error' => 'This booking does not await validation']);
    }
}
