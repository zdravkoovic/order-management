<?php

namespace App\Domain\Events;

use App\Domain\Events\Abstraction\IDomainEvent;
use App\Domain\Shared\Uuid;
use DateTime;

class DomainEvent implements IDomainEvent
{
    public readonly int $version;
    public readonly string $aggregateType;
    public readonly string $eventType;
    public readonly Uuid $id;
    public readonly DateTime $occurredOnUtc;
    public readonly Uuid $aggregateId;
    public readonly string $traceInfo;
    
    public static array $events = [];

    public function __construct(Uuid $aggregateId, DateTime $occuredOnUtc, string $aggregateType)
    {
        $this->id = Uuid::generate();
        $this->aggregateId = $aggregateId;
        $this->occurredOnUtc = $occuredOnUtc;
        $this->aggregateType = $aggregateType;
        $this->eventType = $this->GetEventType($this);
    }

    public static function record(object $event): void
    {
        self::$events[] = $event;
    }

    public static function release() : array
    {
        $events = self::$events;
        self::$events = [];
        return $events;
    }

    public function clear() : void
    {
        self::$events = [];
    }

    public function version() : int
    {
        return $this->version;
    }
    public function aggregateType() : string
    {
        return $this->aggregateId;
    }
    public function eventType() : string
    {
        return $this->eventType;
    }
    public function id() : Uuid
    {
        return $this->id;
    }
    public function occurredOnUtc() : DateTime
    {
        return $this->occurredOnUtc;
    }
    public function aggregateId() : Uuid
    {
        return $this->aggregateId;
    }
    public function traceInfo() : ?string
    {
        return $this->traceInfo;
    }

    private function GetEventType(IDomainEvent $event) : string
    {
        return $event::class;
    }
}