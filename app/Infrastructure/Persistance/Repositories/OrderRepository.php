<?php

namespace App\Infrastructure\Persistance\Repositories;

use App\Domain\Interfaces\IOrderRepository;
use App\Domain\OrderAggregate\CustomerId;
use App\Domain\OrderAggregate\Order;
use App\Domain\OrderAggregate\OrderId;
use App\Domain\OrderAggregate\OrderState;
use App\Infrastructure\Persistance\Models\OrderEntity;
use App\Infrastructure\Services\OrderMapper;
use Carbon\Carbon;

class OrderRepository implements IOrderRepository
{
    public function __construct(private OrderMapper $mapper)
    {}

    public function GetById(OrderId $id) : Order | null
    {
        $order = OrderEntity::find($id->value());
        return $this->mapper->toDomain($order);
    }

    public function IsExists(OrderId $id) : bool
    {
        return OrderEntity::find($id->value()) != null;
    }
    
    /**
     * Get all orders.
     *
     * @return Order[] | null$
    */
    public function GetAll() : iterable | null
    {
        return OrderEntity::all();
    }

    public function Add(Order $order) : OrderId
    {
        $order = $this->mapper->toEntity($order);
        $order->save();
        return OrderId::fromString($order->id);
    }

    public function Update(Order $order) : Order
    {
        /** @var OrderEntity $orderEntity */
        $orderEntity = OrderEntity::where('id', $order->id->value())->first();

        $orderEntity->customer_id = $order->customerId->value();
        $orderEntity->total_amount = $order->totalAmount->value();
        $orderEntity->payment_method = $order->paymentMethod->value;
        $orderEntity->reference = $order->reference->value();
        $orderEntity->updated_at = Carbon::now();

        $orderEntity->save();

        return $this->mapper->toDomain($orderEntity);
    }

    public function Delete(OrderId $id) : void
    {
        OrderEntity::destroy($id->value());
    }

    public function findOrderStateForCustomer(CustomerId $id): ?OrderState
    {
        $state = OrderEntity::where('customer_id', $id->value())
                ->orderBy('created_at', 'desc')
                ->value('state');
        return $state ? OrderState::from($state->value) : null;
    }
}