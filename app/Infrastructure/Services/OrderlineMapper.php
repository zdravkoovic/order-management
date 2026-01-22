<?php

namespace App\Infrastructure\Services;

use App\Domain\OrderlineAggregate\Orderline;
use App\Domain\OrderlineAggregate\OrderlineId;
use App\Domain\OrderlineAggregate\ProductId;
use App\Domain\OrderlineAggregate\Quantity;
use App\Infrastructure\Persistance\Models\OrderEntity;
use App\Infrastructure\Persistance\Models\OrderlineEntity;

class OrderlineMapper
{
    public function __construct(
        private OrderMapper $mapper
    ){}

    public function toDomain(OrderlineEntity $data): Orderline
    {
        return Orderline::reconstitute(
            OrderlineId::fromString($data->id),
            ProductId::fromString($data->product_id),
            Quantity::fromInt($data->quantity),
            $this->mapper->toDomain($data->order)
        );
    }

    public function toEntity(Orderline $order): OrderlineEntity
    {
        $entity = new OrderlineEntity();
        $entity->id = $order->id->value()->__toString();
        $entity->product_id = $order->productId;
        $entity->quantity = $order->quantity->value();
        $entity->order = $this->mapper->toEntity($order->order);
        $entity->order_id = $entity->order->id;
        return $entity;
    }
}