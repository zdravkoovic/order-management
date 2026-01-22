<?php

namespace App\Domain\OrderAggregate\Ports;

use App\Domain\OrderAggregate\OrderNumber;

interface OrderNumberGenerator
{
    public function next(): OrderNumber;
}