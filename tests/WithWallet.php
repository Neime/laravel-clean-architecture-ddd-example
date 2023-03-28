<?php

namespace Tests;

use App\Bank\Wallet\Infrastructure\Laravel\EloquentWallet;
use Illuminate\Foundation\Testing\WithFaker;

trait WithWallet
{
    use WithFaker;
    use WithLearner;

    protected function newWallet(): EloquentWallet
    {
        $learner = $this->newLearner();

        $wallet = new EloquentWallet();
        $wallet->user_id = $learner->id;

        $wallet->save();

        return $wallet;
    }
}
