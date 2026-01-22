<?php

namespace App\Domain\OrderAggregate\Events;

use App\Domain\Events\DomainEvent;
use App\Domain\Shared\Uuid;
use Carbon\Carbon;
use DateTime;

abstract class BaseOrderDomainEvent extends DomainEvent
{
    private const AGGREGATE_TYPE = 'order';
    public function __construct(Uuid $aggregateId, ?DateTime $occuredOnUtc = null)
    {
        return parent::__construct($aggregateId, $occuredOnUtc ?? Carbon::now(), self::AGGREGATE_TYPE);
    }
}