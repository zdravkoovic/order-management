<?php

namespace App\Domain\OrderAggregate\Errors;

use DateTimeImmutable;

final class OrderExpirationTimeViolated extends \DomainException
{
    protected $message;
    public function __construct(private readonly DateTimeImmutable $creationTime, private readonly DateTimeImmutable $expirationTime) 
    {
        $this->message = "Expiration time was exceeded. Please, create new order.";
        $this->expirationTime = $expirationTime;
    }

    public function getExpirationTime() : DateTimeImmutable
    {
        return $this->expirationTime;
    }

    public function getCretionTime() : DateTimeImmutable
    {
        return $this->creationTime;
    }
}