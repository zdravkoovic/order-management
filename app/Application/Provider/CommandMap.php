<?php

namespace App\Application\Provider;

use App\Application\Order\Commands\CreateOrder\CreateOrderCommand;
use App\Application\Order\Commands\CreateOrder\CreateOrderCommandHandler;
use App\Application\Order\Commands\DeleteOrder\DeleteOrderCommand;
use App\Application\Order\Commands\DeleteOrder\DeleteOrderCommandHandler;
use App\Application\Order\Commands\ExpireDraftOrder\ExpireDraftOrderCommand;
use App\Application\Order\Commands\ExpireDraftOrder\ExpireDraftOrderCommandHandler;
use App\Application\Orderline\Commands\CreateOrderline\CreateOrderlineCommand;
use App\Application\Orderline\Commands\CreateOrderline\CreateOrderlineCommandHandler;

final class CommandMap
{
    public const MAP = [
        CreateOrderCommand::class => CreateOrderCommandHandler::class,
        ExpireDraftOrderCommand::class => ExpireDraftOrderCommandHandler::class,
        CreateOrderlineCommand::class => CreateOrderlineCommandHandler::class,
        DeleteOrderCommand::class => DeleteOrderCommandHandler::class
    ];
}