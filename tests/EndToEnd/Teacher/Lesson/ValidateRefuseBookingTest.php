<?php

namespace Tests\EndToEnd\Teacher\Lesson;

use App\Bank\Wallet\Domain\PaymentStatus;
use App\Shared\Domain\ValueObject\UuidValueObject;
use App\Teacher\Lesson\Domain\ValidationState;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;
use Tests\WithBookings;
use Tests\WithLearner;
use Tests\WithLessons;

class ValidateRefuseBookingTest extends TestCase
{
    use WithFaker;
    use WithLessons;
    use WithBookings;
    use WithLearner;

    private string $validateBookingUri;

    protected function setUp(): void
    {
        parent::setUp();
        $this->validateBookingUri = '/api/booking/%s/validation-state';
    }

    /** @test **/
    public function canValidateBooking(): void
    {
        $booking = $this->newBook($this->newLearner(), ValidationState::PENDING);

        $parameters = [
            'status' => ValidationState::ACCEPTED,
        ];

        $response = $this->postJson(sprintf($this->validateBookingUri, $booking->id), $parameters);

        $response->assertStatus(Response::HTTP_CREATED);

        $this->assertDatabaseHas('book', ['id' => $booking->id, 'status' => ValidationState::ACCEPTED]);
    }

    /** @test **/
    public function canRefuseBooking(): void
    {
        $booking = $this->newBook($this->newLearner(), ValidationState::PENDING);

        $parameters = [
            'status' => ValidationState::REFUSED,
        ];

        $response = $this->postJson(sprintf($this->validateBookingUri, $booking->id), $parameters);

        $response->assertStatus(Response::HTTP_CREATED);

        $this->assertDatabaseHas('book', ['id' => $booking->id, 'status' => ValidationState::REFUSED]);
    }

    /** @test **/
    public function cannotDoActionBookingNotExist(): void
    {
        $parameters = [
            'status' => 'bad_status',
        ];

        $response = $this->postJson(sprintf($this->validateBookingUri, UuidValueObject::random()), $parameters);

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(['error' => 'No validation state founded']);
    }

    /** @test **/
    public function cannotValidateOrRefuseBookingNotExist(): void
    {
        $parameters = [
            'status' => ValidationState::REFUSED,
        ];

        $response = $this->postJson(sprintf($this->validateBookingUri, UuidValueObject::random()), $parameters);

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(['error' => 'This booking does not exist']);

        $parameters = [
            'status' => ValidationState::ACCEPTED,
        ];

        $response = $this->postJson(sprintf($this->validateBookingUri, UuidValueObject::random()), $parameters);

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(['error' => 'This booking does not exist']);
    }

    /** @test **/
    public function cannotValidateBookingIsNotPending(): void
    {
        $booking = $this->newBook($this->newLearner(), ValidationState::ACCEPTED);

        $parameters = [
            'status' => ValidationState::ACCEPTED,
        ];

        $response = $this->postJson(sprintf($this->validateBookingUri, $booking->id), $parameters);

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(['error' => 'This booking does not wait to be validated']);

        $booking = $this->newBook($this->newLearner(), ValidationState::REFUSED);

        $parameters = [
            'status' => ValidationState::ACCEPTED,
        ];

        $response = $this->postJson(sprintf($this->validateBookingUri, $booking->id), $parameters);

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(['error' => 'This booking does not wait to be validated']);
    }

    /** @test **/
    public function cannotRefuseBookingIsNotPending(): void
    {
        $booking = $this->newBook($this->newLearner(), ValidationState::ACCEPTED);

        $parameters = [
            'status' => ValidationState::REFUSED,
        ];

        $response = $this->postJson(sprintf($this->validateBookingUri, $booking->id), $parameters);

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(['error' => 'This booking does not await to refuse']);

        $booking = $this->newBook($this->newLearner(), ValidationState::REFUSED);

        $parameters = [
            'status' => ValidationState::REFUSED,
        ];

        $response = $this->postJson(sprintf($this->validateBookingUri, $booking->id), $parameters);

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(['error' => 'This booking does not await to refuse']);
    }

    /** @test **/
    public function cannotValidateBookingIsPaymentIsNotValid(): void
    {
        $booking = $this->newBook($this->newLearner(), ValidationState::PENDING, paymentStatus: PaymentStatus::FAILED);

        $parameters = [
            'status' => ValidationState::ACCEPTED,
        ];

        $response = $this->postJson(sprintf($this->validateBookingUri, $booking->id), $parameters);

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(['error' => 'This booking does not wait to be validated']);
    }

    /** @test **/
    public function cannotRefuseBookingIsPaymentIsNotValid(): void
    {
        $booking = $this->newBook($this->newLearner(), ValidationState::PENDING, paymentStatus: PaymentStatus::FAILED);

        $parameters = [
            'status' => ValidationState::REFUSED,
        ];

        $response = $this->postJson(sprintf($this->validateBookingUri, $booking->id), $parameters);

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(['error' => 'This booking does not await to refuse']);
    }
}
