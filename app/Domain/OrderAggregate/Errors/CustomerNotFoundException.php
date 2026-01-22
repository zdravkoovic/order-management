<?php

namespace App\Domain\OrderAggregate\Errors;

final class CustomerNotFoundException extends \DomainException
{
    protected $message;

    public function __construct() {
        $this->message = 'Order must has customer to be completed';
    }
}