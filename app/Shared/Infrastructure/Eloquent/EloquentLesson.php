<?php

namespace App\Shared\Infrastructure\Eloquent;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class EloquentLesson extends Model
{
    use HasUuids;

    protected $table = 'lesson';
}
