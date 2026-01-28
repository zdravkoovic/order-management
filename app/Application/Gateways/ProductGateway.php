<?php

namespace App\Application\Gateways;


interface ProductGateway
{
    public function exists(int $productId): bool;
    public function existAll(array $productIds): bool;
    public function getProductPricesAndQuantities(array $productIds): ?array;
}