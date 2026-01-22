<?php

namespace App\Domain;

use App\Domain\Events\Abstraction\IDomainEvent;
use App\Domain\Events\DomainEvent;

interface IAggregateRoot 
{
    /**
     * Returns and clears the domain events.
     *
     * @return IDomainEvent[]
     */
    public function PopDomainEvents(): array;
    public function ClearEvents(): void;
}

trait AggregateRoot
{
    /**
     * @var IDomainEvent[]
     */
    private array $domainEvents = [];

    public function PopDomainEvents(): array
    {
        $events = $this->domainEvents;
        $this->ClearEvents();
        return $events;
    }

    public function ClearEvents(): void
    {
        $this->domainEvents = [];
    }

    protected function RaiseDomainEvent(IDomainEvent $event): void
    {
        $this->domainEvents[] = $event;
        DomainEvent::record($event);
    }
}