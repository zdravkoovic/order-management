<?php

namespace App\Application\Abstraction;

use App\Application\Command\CommandResult;
use App\Domain\Shared\Uuid;

interface ICommandHandler
{
    public function Handle(ICommand $command) : CommandResult;
}