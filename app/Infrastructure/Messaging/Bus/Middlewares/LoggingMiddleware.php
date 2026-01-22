<?php

namespace App\Infrastructure\Messaging\Bus\Middlewares;

use App\Application\Abstraction\ICommand;
use App\Application\Bus\ICommandMiddleware;
use App\Application\Command\CommandResult;
use Psr\Log\LoggerInterface;

final class LoggingMiddleware implements ICommandMiddleware
{
    public function __construct(
        private LoggerInterface $logger
    ){}

    public function handle(ICommand $command, callable $next): CommandResult
    {
        $ctx = array_merge([
            'command' => $command,
            'commandId' => $command->commandId(),
        ], $command->toLogContext());

        $this->logger->info('Dispatching command', $ctx);

        try {
            /** @var CommandResult $result */
            $result = $next($command);
        } catch (\Throwable $e) {
            $this->logger->error('command.exception', array_merge($ctx, [
                'exception' => get_class($e),
                'message' => $e->getMessage()
            ]));
            throw $e;
        }

        $logResult = is_object($result) ? $this->flattenResult($result) : $result;

        $this->logger->info('command.completed', array_merge($ctx, ['result' => $logResult]));

        return $result;
    }

    /** @param CommandResult $result */
    private function flattenResult($result): array
    {
        return [
            'success' => $result->success ?? false,
            'id' => $result->id ?? null,
            'error_code' => $result->appError->code ?? null
        ];
    }
}
