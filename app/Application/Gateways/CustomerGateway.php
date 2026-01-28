<?php

namespace App\Application\Gateways;

interface CustomerGateway
{
    public function exists(string $customerId): bool;
}