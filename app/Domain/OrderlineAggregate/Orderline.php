<?php

namespace App\Domain\OrderlineAggregate;

use App\Domain\IAggregateRoot;
use App\Domain\AggregateRoot;
use App\Domain\OrderAggregate\Money;
use App\Domain\OrderAggregate\Order;
use App\Domain\OrderlineAggregate\Events\QuantityUpdatedEvent;

class Orderline implements IAggregateRoot
{
    use AggregateRoot;

    public readonly ?OrderlineId $id;
    public readonly ProductId $productId;
    public readonly Quantity $quantity;
    public readonly Money $price;
    public readonly Order $order;

    private function __construct(ProductId $productId, Quantity $quantity, Money $price, Order $order, ?OrderlineId $id = null)
    {
        $this->id = $id;
        $this->productId = $productId;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->order = $order;
    }

    public static function Create(string $productId, int $quantity, float $price, Order $order) : self
    {
        $orderlineProductId = ProductId::fromString($productId);
        $quantity = Quantity::fromInt($quantity);
        $price = Money::fromFloat($price);

        return new self($orderlineProductId, $quantity, $price, $order);
    }

    public static function reconstitute(
        OrderlineId $id,
        ProductId $productId,
        Quantity $quantity,
        Money $price,
        Order $order
    ) : self {

        return new self($productId, $quantity, $price, $order, $id);
    }

    public function UpdateQuantity(int $value) : self
    {
        $newQuantity = Quantity::fromInt($value);
        $this->quantity = $newQuantity;

        $this->RaiseDomainEvent(new QuantityUpdatedEvent($this));

        return $this;
    }
}