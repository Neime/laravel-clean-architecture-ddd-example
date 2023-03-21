<?php

namespace App\Shared\Infrastructure\Bus;

use App\Shared\Application\Command;
use App\Shared\Application\CommandBus;
use Illuminate\Support\Facades\App;

class InMemoryCommandBus implements CommandBus
{
    public function handle(Command $command): void
    {
        // resolve handler
        $reflection = new \ReflectionClass($command);
        $handlerName = str_replace('Command', 'Handler', $reflection->getShortName());
        $handlerName = str_replace($reflection->getShortName(), $handlerName, $reflection->getName());
        $handler = App::make($handlerName);
        // invoke handler
        $handler($command);
    }
}
