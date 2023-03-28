<?php

namespace App\Bank\Wallet\Infrastructure\Laravel;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EloquentTransaction extends Model
{
    use HasUuids;

    protected $table = 'transaction';

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(EloquentWallet::class, 'wallet_id');
    }
}
