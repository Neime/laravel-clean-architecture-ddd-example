<?php

namespace App\Shared\Infrastructure\Eloquent;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EloquentBook extends Model
{
    use HasUuids;

    protected $table = 'book';

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(EloquentLesson::class, 'lesson_id');
    }

    public function learner(): BelongsTo
    {
        return $this->belongsTo(EloquentUser::class, 'learner_id');
    }
}
