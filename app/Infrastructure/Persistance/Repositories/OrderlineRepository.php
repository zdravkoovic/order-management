<?php

namespace App\Infrastructure\Persistance\Repositories;

use App\Domain\Interfaces\IOrderlineRepository;
use App\Domain\OrderlineAggregate\Orderline;
use App\Domain\OrderlineAggregate\OrderlineId;
use App\Infrastructure\Persistance\Models\OrderlineEntity;
use App\Infrastructure\Services\OrderlineMapper;
use App\Infrastructure\Services\OrderMapper;

class OrderlineRepository implements IOrderlineRepository
{
    public function __construct(
        private OrderlineMapper $orderlineMapper,
        private OrderMapper $orderMapper
    )
    {}

    public function GetById(OrderlineId $id) : Orderline | null
    {
        $orderline = OrderlineEntity::find($id->value());
        return $this->orderlineMapper->toDomain($orderline);
    }

    public function IsExists(OrderlineId $id) : bool
    {
        return OrderlineEntity::find($id->value()) != null;
    }
    
    /**
     * Get all orders.
     *
     * @return Order[] | null$
    */
    public function GetAll() : iterable | null
    {
        return OrderlineEntity::all();
    }

    public function Add(Orderline $entity) : OrderlineId
    {
        $orderline = OrderlineEntity::create($entity);
        $orderline->save();
        return OrderlineId::fromString($orderline->id);
    }
    public function Update(Orderline $entity) : Orderline
    {
        /** @var OrderlineEntity $orderlineEntity */
        $orderlineEntity = OrderlineEntity::where('id', $entity->id->value())->first();

        $orderlineEntity->product_id = $entity->productId->id;
        $orderlineEntity->order = $this->orderMapper->toEntity($entity->order);
        $orderlineEntity->quantity = $entity->quantity->value();

        $orderlineEntity->save();

        return $this->orderlineMapper->toDomain($orderlineEntity);
    }

    public function Delete(OrderlineId $id) : void
    {
        OrderlineEntity::destroy($id->value());
    }
}