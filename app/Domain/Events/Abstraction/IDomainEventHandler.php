<?php

namespace App\Domain\Events\Abstraction;

interface IDomainEventHandler
{
    public function Handle(IDomainEvent $event): void;
}