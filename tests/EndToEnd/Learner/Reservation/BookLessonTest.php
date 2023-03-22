<?php

namespace Tests\EndToEnd\Learner\User;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;
use Tests\WithLearner;
use Tests\WithLessons;

class BookLessonTest extends TestCase
{
    use WithFaker;
    use WithLessons;
    use WithLearner;

    private string $bookLessonUri;

    protected function setUp(): void
    {
        parent::setUp();
        $this->bookLessonUri = '/api/book';
    }

    /** @test **/
    public function canBookLesson(): void
    {
        $lessonAvailable = $this->newLessonAvailable();
        $learner = $this->newLearner();

        $parameters = [
            'learner_id' => $learner->id,
            'lesson_id' => $lessonAvailable->id,
        ];

        $response = $this->postJson($this->bookLessonUri, $parameters);

        $response->assertStatus(Response::HTTP_CREATED);

        // Asset cannot create book with same lesson has already accepted or pending
        $response = $this->postJson($this->bookLessonUri, $parameters);
        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(['error' => 'This lesson is already pending or accepted']);

        $this->assertDatabaseHas('book', ['learner_id' => $learner->id, 'lesson_id' => $lessonAvailable->id, 'status' => 'pending']);
    }
}
