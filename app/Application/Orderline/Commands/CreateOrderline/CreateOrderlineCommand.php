<?php

namespace App\Application\Orderline\Commands\CreateOrderline;

use App\Application\Abstraction\ICommand;
use App\Domain\OrderAggregate\Order;

final class CreateOrderlineCommand implements ICommand
{
    public function __construct(
        public readonly string $orderId,
        public readonly int $productId,
        public readonly int $quantity,
        public readonly float $price,
        public readonly Order $order
    ){}
}