<?php

namespace App\Domain\OrderAggregate\Errors;

use App\Domain\OrderAggregate\OrderId;

final class TotalAmountViolationException extends \DomainException
{
    protected $message;

    public function __construct(private readonly OrderId $orderId) {
        $this->message = "Total amount cannot be zero in order to complete your order.";
    }

    public function getOrderId()
    {
        return $this->orderId;
    }
}