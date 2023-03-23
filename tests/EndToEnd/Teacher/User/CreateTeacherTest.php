<?php

namespace Tests\EndToEnd\Teacher\User;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class CreateTeacherTest extends TestCase
{
    use WithFaker;
    private string $createTeacherUri;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createTeacherUri = '/api/teacher';
    }

    /** @test **/
    public function canCreateTeacher(): void
    {
        $parameters = [
            'company_name' => $this->faker->company,
            'firstname' => $this->faker->firstname,
            'lastname' => $this->faker->lastname,
            'email' => $this->faker->safeEmail,
            'password' => $this->faker->password(8),
        ];

        $response = $this->postJson($this->createTeacherUri, $parameters);

        $response->assertStatus(Response::HTTP_CREATED);

        // Asset cannot create user with same email
        $response = $this->postJson($this->createTeacherUri, $parameters);
        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(['error' => 'This email is already exist']);

        // Assert database has the first user created
        unset($parameters['password']);

        $this->assertDatabaseHas('users', $parameters);
    }

    /** @test **/
    public function cannotCreateTeacherWithoutEmail(): void
    {
        $parameters = [
            'company_name' => $this->faker->company,
            'firstname' => $this->faker->firstname,
            'lastname' => $this->faker->lastname,
            'password' => $this->faker->password(8),
        ];

        $response = $this->postJson($this->createTeacherUri, $parameters);

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(['error' => 'Must be a valid email']);
    }

    /** @test **/
    public function cannotCreateTeacherWithoutPassword(): void
    {
        $parameters = [
            'company_name' => $this->faker->company,
            'firstname' => $this->faker->firstname,
            'lastname' => $this->faker->lastname,
            'email' => $this->faker->safeEmail,
        ];

        $response = $this->postJson($this->createTeacherUri, $parameters);

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(['error' => 'Password must be filled']);
    }

    /** @test **/
    public function cannotCreateTeacherWithoutCompanyName(): void
    {
        $parameters = [
            'firstname' => $this->faker->firstname,
            'lastname' => $this->faker->lastname,
            'email' => $this->faker->safeEmail,
            'password' => $this->faker->password(8),
        ];

        $response = $this->postJson($this->createTeacherUri, $parameters);

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(['error' => 'Company name must be filled']);
    }
}
