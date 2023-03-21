<?php

namespace App\Shared\Infrastructure\Bus;

use App\Shared\Application\Query;
use App\Shared\Application\QueryBus;
use App\Shared\Application\Response;
use Illuminate\Support\Facades\App;

class InMemoryQueryBus implements QueryBus
{
    public function handle(Query $query): Response
    {
        // resolve handler
        $reflection = new \ReflectionClass($query);
        $handlerName = str_replace('Query', 'Handler', $reflection->getShortName());
        $handlerName = str_replace($reflection->getShortName(), $handlerName, $reflection->getName());
        $handler = App::make($handlerName);
        // invoke handler
        return $handler($query);
    }
}
