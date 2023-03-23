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
        $lesson = $this->newLesson();
        $learner = $this->newLearner();

        $parameters = [
            'learner_id' => $learner->id,
            'lesson_id' => $lesson->id,
        ];

        $response = $this->postJson($this->bookLessonUri, $parameters);

        $response->assertStatus(Response::HTTP_CREATED);

        // Asset cannot create book with same lesson has already accepted or pending
        $response = $this->postJson($this->bookLessonUri, $parameters);
        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(['error' => 'This lesson is not available']);

        $this->assertDatabaseHas('book', ['learner_id' => $learner->id, 'lesson_id' => $lesson->id, 'status' => 'pending']);
    }
}
