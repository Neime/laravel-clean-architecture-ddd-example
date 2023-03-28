<?php

namespace App\Bank\Wallet\Infrastructure\Laravel;

use App\Shared\Infrastructure\Eloquent\EloquentUser;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EloquentWallet extends Model
{
    use HasUuids;

    protected $table = 'wallet';

    public function user(): BelongsTo
    {
        return $this->belongsTo(EloquentUser::class, 'user_id');
    }
}
