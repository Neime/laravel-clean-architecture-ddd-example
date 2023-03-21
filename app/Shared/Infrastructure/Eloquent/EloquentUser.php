<?php

namespace App\Shared\Infrastructure\Eloquent;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Learner\User\Domain\Learner;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class EloquentUser extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasUuids;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];
}
