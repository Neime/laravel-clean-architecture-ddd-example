<?php

namespace Tests;

use App\Shared\Infrastructure\Eloquent\EloquentUser;
use Illuminate\Foundation\Testing\WithFaker;

trait WithTeacher
{
    use WithFaker;

    protected function newTeacher(): EloquentUser
    {
        $teacher = new EloquentUser();
        $teacher->type = EloquentUser::TEACHER_TYPE;
        $teacher->companyName = $this->faker->companyName;
        $teacher->email = $this->faker->safeEmail;
        $teacher->password = $this->faker->password(8);
        $teacher->save();

        return $teacher;
    }
}
