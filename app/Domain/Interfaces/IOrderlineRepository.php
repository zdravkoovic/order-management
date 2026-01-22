<?php

namespace App\Domain\Interfaces;

use App\Domain\OrderlineAggregate\Orderline;
use App\Domain\OrderlineAggregate\OrderlineId;
use App\Infrastructure\Persistance\Models\OrderlineEntity;

interface IOrderlineRepository
{
    public function GetById(OrderlineId $id) : Orderline | null;
    public function IsExists(OrderlineId $id) : bool;
    
    /**
     * Get all orders.
     *
     * @return Orderline[]
     */
    public function GetAll() : iterable | null;
    
    public function Add(Orderline $entity) : OrderlineId;
    public function Update(Orderline $entity) : Orderline;
    public function Delete(OrderlineId $id) : void;
}