<?php

declare(strict_types=1);

namespace App\Shared\Application;

interface CommandBus
{
    public function handle(Command $command): void;
}
