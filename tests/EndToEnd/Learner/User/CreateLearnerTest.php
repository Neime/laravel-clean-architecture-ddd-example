<?php

namespace Tests\EndToEnd\Learner\User;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class CreateLearnerTest extends TestCase
{
    use WithFaker;
    private string $createLearnerUri;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createLearnerUri = '/api/learner';
    }

    /** @test **/
    public function canCreateLearner(): void
    {
        $parameters = [
            'firstname' => $this->faker->firstname,
            'lastname' => $this->faker->lastname,
            'email' => $this->faker->safeEmail,
            'password' => $this->faker->password(8),
        ];

        $response = $this->postJson($this->createLearnerUri, $parameters);

        $response->assertStatus(Response::HTTP_CREATED);

        // Asset cannot create user with same email
        $response = $this->postJson($this->createLearnerUri, $parameters);
        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(['error' => 'This email is already exist']);

        // Assert database has the first user created
        unset($parameters['password']);

        $this->assertDatabaseHas('users', $parameters);
    }

    /** @test **/
    public function cannotCreateLearnerWithoutEmail(): void
    {
        $parameters = [
            'firstname' => $this->faker->firstname,
            'lastname' => $this->faker->lastname,
            'password' => $this->faker->password(8),
        ];

        $response = $this->postJson($this->createLearnerUri, $parameters);

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(['error' => 'Must be a valid email']);
    }

    /** @test **/
    public function cannotCreateLearnerWithoutPassword(): void
    {
        $parameters = [
            'firstname' => $this->faker->firstname,
            'lastname' => $this->faker->lastname,
            'email' => $this->faker->safeEmail,
        ];

        $response = $this->postJson($this->createLearnerUri, $parameters);

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(['error' => 'Password must be filled']);
    }
}
