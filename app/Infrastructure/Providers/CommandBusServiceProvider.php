<?php

namespace App\Infrastructure\Providers;

use App\Application\Bus\CommandMap;
use App\Application\Bus\ICommandBus;
use App\Infrastructure\Messaging\Bus\CommandBus;
use App\Infrastructure\Messaging\Bus\Middlewares\LoggingMiddleware;
use App\Infrastructure\Messaging\Bus\Middlewares\TransactionMiddleware;
use Illuminate\Support\ServiceProvider;
use Psr\Log\LoggerInterface;

final class CommandBusServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(ICommandBus::class, function ($app) {
            $middleware = [
                new TransactionMiddleware(),
                new LoggingMiddleware($app->make(LoggerInterface::class))
            ];

            return new CommandBus(
                $app,
                CommandMap::MAP,
                $middleware
            );
        });
    }
}