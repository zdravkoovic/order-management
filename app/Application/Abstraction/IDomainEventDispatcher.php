<?php

namespace App\Application\Abstraction;

use App\Domain\Events\Abstraction\IDomainEvent;

interface IDomainEventDispatcher
{
    public function dispatch(IDomainEvent $event) : void;
    public function resolveHandler(object $command) : ?object;
}