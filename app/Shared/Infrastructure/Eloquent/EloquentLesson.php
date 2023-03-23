<?php

namespace App\Shared\Infrastructure\Eloquent;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EloquentLesson extends Model
{
    use HasUuids;

    protected $table = 'lesson';

    public function books(): HasMany
    {
        return $this->hasMany(EloquentBook::class);
    }
}
