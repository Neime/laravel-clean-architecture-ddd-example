<?php

namespace Tests;

use App\Shared\Infrastructure\Eloquent\EloquentUser;
use Illuminate\Foundation\Testing\WithFaker;

trait WithLearner
{
    use WithFaker;

    protected function newLearner(): EloquentUser
    {
        $learner = new EloquentUser();
        $learner->email = $this->faker->safeEmail;
        $learner->password = $this->faker->password(8);
        $learner->save();

        return $learner;
    }
}
