<?php

namespace App\Domain\Interfaces;

use App\Domain\OrderAggregate\CustomerId;
use App\Domain\OrderAggregate\Order;
use App\Domain\OrderAggregate\OrderId;
use App\Domain\OrderAggregate\OrderState;

interface IOrderRepository
{
    public function GetById(OrderId $id) : Order | null;
    public function IsExists(OrderId $id) : bool;
    
    /**
     * Get all orders.
     *
     * @return Order[] | null
     */
    public function GetAll() : iterable | null;
    
    public function Add(Order $id) : OrderId;
    public function Update(Order $id) : Order;
    public function Delete(OrderId $id) : void;

    public function findOrderStateForCustomer(CustomerId $id) : ?OrderState;
}