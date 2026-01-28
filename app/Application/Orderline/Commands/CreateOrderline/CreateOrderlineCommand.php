<?php

namespace App\Application\Orderline\Commands\CreateOrderline;

use App\Application\Abstraction\IAction;
use App\Application\Abstraction\ICommand;
use App\Domain\Shared\Uuid;

final class CreateOrderlineCommand implements ICommand, IAction
{
    private string $commandId;

    public function __construct(
        public readonly string $orderId,
        public readonly array $productIds,
        public readonly array $quantities,
    ){
        $this->commandId = Uuid::generate()->__toString();
    }

    public function commandId(): string
    {
        return $this->commandId;
    }

    public function toLogContext() : array
    {
        return [
            'command_id' => $this->commandId,
            'order_id' => $this->orderId,
            'product_ids' => $this->productIds,
            'quantities' => $this->quantities
        ];
    }
}