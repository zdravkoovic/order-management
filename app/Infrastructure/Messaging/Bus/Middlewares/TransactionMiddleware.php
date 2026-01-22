<?php

namespace App\Infrastructure\Messaging\Bus\Middlewares;

use App\Application\Abstraction\ICommand;
use App\Application\Bus\ICommandMiddleware;
use App\Application\Command\CommandResult;
use Illuminate\Support\Facades\DB;

final class TransactionMiddleware implements ICommandMiddleware
{
    public function handle(ICommand $command, callable $next): CommandResult
    {
        return DB::transaction(function () use ($next, $command) {
            return $next($command);
        });
    }
}