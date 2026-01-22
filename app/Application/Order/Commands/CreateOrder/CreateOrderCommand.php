<?php 

namespace App\Application\Order\Commands\CreateOrder;

use App\Application\Abstraction\ICommand;

final class CreateOrderCommand implements ICommand
{
    public function __construct(
        public readonly string $customerId,
        public readonly bool $isGuest,
        public readonly ?float $amount = null,
        public readonly ?string $paymentMethod = null,
    ){}
}