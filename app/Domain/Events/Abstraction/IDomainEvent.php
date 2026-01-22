<?php

namespace App\Domain\Events\Abstraction;

use App\Domain\Shared\Uuid;
use DateTime;

interface IDomainEvent
{
    public function version() : int;
    public function aggregateType() : string;
    public function eventType() : string;
    public function id() : Uuid;
    public function occurredOnUtc() : DateTime;
    public function aggregateId() : Uuid;
    public function traceInfo() : ?string;
}