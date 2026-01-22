<?php

namespace App\Providers;

use App\Application\Bus\CommandMap;
use App\Application\Bus\ICommandBus;
use App\Application\UnitOfWork\IUnitOfWork;
use App\Domain\AggregateRoot;
use App\Domain\IAggregateRoot;
use App\Domain\Interfaces\IOrderRepository;
use App\Infrastructure\Messaging\Bus\CommandBus;
use App\Infrastructure\Messaging\Bus\Middlewares\LoggingMiddleware;
use App\Infrastructure\Messaging\Bus\Middlewares\TransactionMiddleware;
use App\Infrastructure\Persistance\Repositories\OrderRepository;
use App\Infrastructure\Persistance\UnitOfWork;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
// use Psr\Log\LoggerInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IOrderRepository::class, OrderRepository::class);

        // $this->app->singleton(ICommandBus::class, function ($app) {
        //     $middleware = [
        //         new TransactionMiddleware(),
        //         new LoggingMiddleware($app->make(LoggerInterface::class))
        //     ];

        //     return new CommandBus(
        //         $app,
        //         CommandMap::MAP,
        //         $middleware
        //     );
        // });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::preventLazyLoading(! $this->app->environment('production'));
        Model::preventSilentlyDiscardingAttributes(! $this->app->environment('production'));
    }
}
