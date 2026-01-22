<?php

namespace App\Infrastructure\Messaging\Bus;

use App\Application\Abstraction\ICommand;
use App\Application\Bus\ICommandBus;
use App\Application\Command\CommandResult;
use Illuminate\Container\Container;
use LogicException;

final class CommandBus implements ICommandBus
{
    public function __construct(
        private Container $container,
        private array $map,
        private ?array $middleware = []
    )
    {}
    
    public function dispatch(ICommand $command): CommandResult
    {
        $handlerClass = $this->map[$command::class] ?? throw new LogicException("No handler found for command " . $command::class);

        $core = function (ICommand $command) use ($handlerClass) : CommandResult {
            $handler = $this->container->make($handlerClass);
            return $handler->handle($command);
        };

        $pipeline = array_reduce(
            array_reverse($this->middleware),
            fn ($next, $middleware) => fn (ICommand $command) => $middleware->handle($command, $next),
            $core
        );

        return $pipeline($command);
    }
}