<?php

namespace App\Shared\Application;

use Illuminate\Support\Facades\App;
use ReflectionClass;

class CommandBus
{
    public function handle($command)
    {
        // resolve handler
        $reflection = new ReflectionClass($command);
        $handlerName = str_replace("Command", "Handler", $reflection->getShortName());
        $handlerName = str_replace($reflection->getShortName(), $handlerName, $reflection->getName());
        $handler = App::make($handlerName);
        // invoke handler
        $handler($command);
    }
}
