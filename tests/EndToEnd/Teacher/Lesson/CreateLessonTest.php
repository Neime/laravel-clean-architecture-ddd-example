<?php

namespace Tests\EndToEnd\Teacher\Lesson;

use App\Shared\Domain\ValueObject\UuidValueObject;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;
use Tests\WithTeacher;

class CreateLessonTest extends TestCase
{
    use WithFaker;
    use WithTeacher;

    private string $createLesson;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createLesson = '/api/lesson';
    }

    /** @test **/
    public function canBookLesson(): void
    {
        $teacher = $this->newTeacher();

        $parameters = [
            'teacher_id' => $teacher->id,
            'start_date' => '2023-12-30 07:00',
            'end_date' => '2023-12-30 08:00',
            'amount' => 2010,
            'currency' => 'EUR',
        ];

        $response = $this->postJson($this->createLesson, $parameters);

        $response->assertStatus(Response::HTTP_CREATED);

        $this->assertDatabaseHas('lesson', [
            'teacher_id' => $teacher->id,
            'start_date' => '2023-12-30T07:00:00+00:00',
            'end_date' => '2023-12-30T08:00:00+00:00',
            'amount' => 2010,
            'currency' => 'EUR',
        ]);
    }

    /** @test **/
    public function cannotCreateLessonWithoutExistingTeacher(): void
    {
        $parameters = [
            'teacher_id' => (string) UuidValueObject::random(),
            'start_date' => '2023-12-30 07:00',
            'end_date' => '2023-12-30 08:00',
            'amount' => 2010,
            'currency' => 'EUR',
        ];

        $response = $this->postJson($this->createLesson, $parameters);

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(['error' => 'This teacher does not exist']);
    }

    /** @test **/
    public function cannotCreateLessonWithEndDateLowerThanStartDate(): void
    {
        $teacher = $this->newTeacher();
        $parameters = [
            'teacher_id' => $teacher->id,
            'start_date' => '2023-12-30 07:00',
            'end_date' => '2023-12-30 06:00',
            'amount' => 2010,
            'currency' => 'EUR',
        ];

        $response = $this->postJson($this->createLesson, $parameters);

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(['error' => 'End date must higher than start date']);
    }

    /** @test **/
    public function cannotCreateLessonWithoutExistingCurrency(): void
    {
        $teacher = $this->newTeacher();
        $parameters = [
            'teacher_id' => $teacher->id,
            'start_date' => '2023-12-30 07:00',
            'end_date' => '2023-12-30 07:30',
            'amount' => 2010,
            'currency' => 'NOT_EXIST',
        ];

        $response = $this->postJson($this->createLesson, $parameters);

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(['error' => 'NOT_EXIST must be a valid currency']);
    }

    /** @test **/
    public function cannotCreateLessonWithAmountNegative(): void
    {
        $teacher = $this->newTeacher();
        $parameters = [
            'teacher_id' => $teacher->id,
            'start_date' => '2023-12-30 07:00',
            'end_date' => '2023-12-30 07:30',
            'amount' => -10,
            'currency' => 'EUR',
        ];

        $response = $this->postJson($this->createLesson, $parameters);

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(['error' => '-10 must be a positive value']);
    }

    /** @test **/
    public function cannotCreateLessonWithFloatAmount(): void
    {
        $teacher = $this->newTeacher();
        $parameters = [
            'teacher_id' => $teacher->id,
            'start_date' => '2023-12-30 07:00',
            'end_date' => '2023-12-30 07:30',
            'amount' => 10.20,
            'currency' => 'EUR',
        ];

        $response = $this->postJson($this->createLesson, $parameters);

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(['error' => 'Price amount must be a integer value']);
    }
}
