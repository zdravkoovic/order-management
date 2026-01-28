<?php

namespace App\Application\Orderline\DTOs;

final class ProductPricesAndQuantities
{
    public function __construct(
        public int $productId,
        public float $price,
        public int $quantity
    ) {}
}