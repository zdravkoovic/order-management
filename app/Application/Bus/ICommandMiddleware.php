<?php

namespace App\Application\Bus;

use App\Application\Abstraction\ICommand;
use App\Application\Command\CommandResult;

interface ICommandMiddleware
{
    public function handle(ICommand $command, callable $next): CommandResult;
}