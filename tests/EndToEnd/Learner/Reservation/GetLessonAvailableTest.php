<?php

namespace Tests\EndToEnd\Learner\Reservation;

use App\Learner\Reservation\Domain\ValidationState;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;
use Tests\WithBookings;
use Tests\WithLearner;
use Tests\WithLessons;

class GetLessonAvailableTest extends TestCase
{
    use WithFaker;
    use WithLessons;
    use WithBookings;
    use WithLearner;

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
        $numberLessonsNotAvailable = $this->faker->numberBetween(1, 10);
        $this->createRandomLessons(3);

        $lessonsNotAvailable = $this->createRandomLessons(5);

        foreach ($lessonsNotAvailable as $lessonNotAvailable) {
            $this->newBook($this->newLearner(), ValidationState::PENDING, $lessonNotAvailable);
        }

        $response = $this->getJson($this->getLessonAvailableUri);

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(3);
    }
}
