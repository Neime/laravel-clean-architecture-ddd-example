<?php

namespace App\Shared\Infrastructure\Laravel\Providers;

use App\Shared\Application\CommandBus;
use App\Shared\Application\QueryBus;
use App\Shared\Infrastructure\Bus\InMemoryCommandBus;
use App\Shared\Infrastructure\Bus\InMemoryQueryBus;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CommandBus::class, InMemoryCommandBus::class);

        $this->app->bind(QueryBus::class, InMemoryQueryBus::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
