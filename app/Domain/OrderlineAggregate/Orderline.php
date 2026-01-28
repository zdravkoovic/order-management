<?php

namespace App\Domain\OrderlineAggregate;

use App\Domain\IAggregateRoot;
use App\Domain\AggregateRoot;
use App\Domain\OrderAggregate\Money;
use App\Domain\OrderAggregate\OrderId;
use App\Domain\OrderlineAggregate\Events\QuantityUpdatedEvent;

class Orderline implements IAggregateRoot
{
    use AggregateRoot;

    public readonly ?OrderlineId $id;
    public readonly ProductId $productId;
    public readonly Quantity $quantity;
    public readonly Money $price;
    public readonly OrderId $orderId;

    private function __construct(ProductId $productId, Quantity $quantity, Money $price, OrderId $orderId, ?OrderlineId $id = null)
    {
        $this->id = $id;
        $this->productId = $productId;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->orderId = $orderId;
    }

    public static function create(string $productId, int $quantity, float $price, string $orderId) : self
    {
        $orderlineProductId = ProductId::fromString($productId);
        $quantity = Quantity::fromInt($quantity);
        $price = Money::fromFloat($price);
        $orderId = OrderId::fromString($orderId);

        return new self($orderlineProductId, $quantity, $price, $orderId);
    }

    public static function reconstitute(
        OrderlineId $id,
        ProductId $productId,
        Quantity $quantity,
        Money $price,
        OrderId $orderId
    ) : self {

        return new self($productId, $quantity, $price, $orderId, $id);
    }

    public function UpdateQuantity(int $value) : self
    {
        $newQuantity = Quantity::fromInt($value);
        $this->quantity = $newQuantity;

        $this->RaiseDomainEvent(new QuantityUpdatedEvent($this));

        return $this;
    }
}