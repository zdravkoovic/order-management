<?php

namespace App\Application\Bus;

use App\Application\Order\Commands\CreateOrder\CreateOrderCommand;
use App\Application\Order\Commands\CreateOrder\CreateOrderCommandHandler;

final class CommandMap
{
    public const MAP = [
        CreateOrderCommand::class => CreateOrderCommandHandler::class,
    ];
}