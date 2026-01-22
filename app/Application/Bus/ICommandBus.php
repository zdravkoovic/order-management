<?php

namespace App\Application\Bus;

use App\Application\Abstraction\ICommand;
use App\Application\Command\CommandResult;

interface ICommandBus
{
    public function dispatch(ICommand $command) : CommandResult;
}