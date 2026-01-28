<?php

namespace App\Application\Order\Commands\DeleteOrder;

use App\Application\Abstraction\IAction;
use App\Application\Abstraction\ICommand;
use App\Domain\Shared\Uuid;

final class DeleteOrderCommand implements ICommand, IAction
{
    private Uuid $commandId;
    
    public function __construct(public string $orderId) {
        $this->commandId = Uuid::generate();    
    }

    public function commandId(): string
    {
        return $this->commandId->__toString();
    }

    public function toLogContext(): array
    {
        return [
            "commandId" => $this->commandId,
            "order_id" => $this->orderId
        ];
    }
}