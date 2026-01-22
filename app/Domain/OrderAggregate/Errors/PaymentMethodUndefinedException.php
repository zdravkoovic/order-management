<?php

namespace App\Domain\OrderAggregate\Errors;

use App\Domain\OrderAggregate\OrderId;

final class PaymentMethodUndefinedException extends \DomainException
{
    protected $message;

    public function __construct(private readonly OrderId $orderId) {
        $this->message = "Payment method is required to complete your order.";
    }

    public function getOrderId() : OrderId
    {
        return $this->orderId;
    }
}