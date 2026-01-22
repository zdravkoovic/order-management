<?php

namespace App\Domain\OrderAggregate;

use DomainException;

final class Money
{
    private float $value;

    private function __construct(float $value)
    {
        if ($value < 0) throw new DomainException('Money cannot be negative');

        $this->value = $value;
    }

    public static function fromFloat(float $value) : self
    {
        return new self($value);
    }

    public function value() : float
    {
        return $this->value;
    }

    public static function zero() : self
    {
        return new self(0.0);
    }
}