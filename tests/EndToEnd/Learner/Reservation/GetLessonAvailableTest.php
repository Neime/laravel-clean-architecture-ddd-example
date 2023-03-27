<?php

namespace Tests\EndToEnd\Learner\Reservation;

use App\Learner\Reservation\Domain\ValidationState;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Testing\Fluent\AssertableJson;
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
    public function getLessonsAvailableOrderByStartDateDesc(): void
    {
        $numberLessonsNotAvailable = $this->faker->numberBetween(1, 10);

        $lessonAvailableOne = $this->newLesson(
            amount: 3000,
            startDate: new \DateTimeImmutable('2023-04-30 07:00'),
            endDate: new \DateTimeImmutable('2023-04-30 07:00')
        );

        $this->newLesson();
        $this->newLesson();

        $lessonsNotAvailable = $this->createRandomLessons($numberLessonsNotAvailable);

        foreach ($lessonsNotAvailable as $lessonNotAvailable) {
            $this->newBook($this->newLearner(), ValidationState::PENDING, $lessonNotAvailable);
        }

        $response = $this->getJson($this->getLessonAvailableUri);

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(3)
            ->assertJson(fn (AssertableJson $json) => $json->has(3)
                ->first(fn (AssertableJson $json) => $json->where('id', $lessonAvailableOne->id)
                    ->where('price', '3000 EUR')
                    ->where('date', sprintf(
                        'From %s to %s',
                        $lessonAvailableOne->start_date->format('Y-m-d H:i'),
                        $lessonAvailableOne->end_date->format('Y-m-d H:i')
                    ))
                    ->etc()
                )
            );
    }
}
