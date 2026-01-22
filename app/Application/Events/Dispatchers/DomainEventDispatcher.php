<?php

namespace App\Application\Events\Dispatchers;

use App\Application\Abstraction\IDomainEventDispatcher;
use App\Domain\Events\Abstraction\IDomainEvent;

class DomainEventDispatcher implements IDomainEventDispatcher
{
    public function dispatch(IDomainEvent $event) : void
    {
        
    }
    public function resolveHandler(object $command) : ?object
    {
        return null;
    }
}