<?php

namespace App\Application\Orderline\Commands\CreateOrderline;

use App\Application\Abstraction\BaseCommandHandler;
use App\Application\Abstraction\ICommand;
use App\Domain\IAggregateRoot;
use App\Domain\OrderlineAggregate\Orderline;
use App\Domain\OrderlineAggregate\ProductId;
use App\Domain\Shared\Uuid;

final class CreateOrderlineCommandHandler extends BaseCommandHandler
{
    private Orderline $createdOrderline;

    /**
     * Undocumented function
     *
     * @param CreateOrderlineCommand $command
     * @return Uuid|null
     */
    public function Execute(ICommand $command): ?Uuid
    {
        $createdOrderline = Orderline::Create(
            $command->productId,
            $command->quantity,
            $command->price,
            $command->order
        );
        throw new \Exception('Not implemented');
    }

    public function GetAggregateRoot(): ?IAggregateRoot
    {
        throw new \Exception('Not implemented');
    }
}