<?php

namespace Tests\EndToEnd\Learner\Reservation;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;
use Tests\WithLessons;

class GetLessonAvailableTest extends TestCase
{
    use WithFaker;
    use WithLessons;

    private string $getLessonAvailableUri;

    protected function setUp(): void
    {
        parent::setUp();
        $this->getLessonAvailableUri = '/api/lessons-available';
    }

    /** @test **/
    public function getLessonsAvailable(): void
    {
        $numberLessons = $this->faker->numberBetween(1, 10);
        $numberLessonsAvailable = $this->faker->numberBetween(1, 10);
        $this->createRandomLessons($numberLessons);
        $this->createRandomLessonsAvailable($numberLessonsAvailable);

        $response = $this->getJson($this->getLessonAvailableUri);

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount($numberLessonsAvailable);
    }
}
