<?php

namespace App\Domain\OrderlineAggregate;

use DomainException;

final class Quantity
{
    private int $value;

    private function __construct(int $value)
    {
        if($value <= 0) throw new DomainException("Quantity must be greater then zero.");

        $this->value = $value;
    }

    public static function fromInt(int $value) : self
    {
        return new self($value);
    }

    public function value() : int
    {
        return $this->value;
    }

    public function equals(Quantity $other) : bool
    {
        return $this->value == $other->value();
    }

    public function add(Quantity $other) : self
    {
        return new self($this->value + $other->value());
    }

    public function substract(Quantity $other) : self
    {
        $new = ($this->value - $other->value());

        if($new <= 0) throw new DomainException("Resulting quantity must be greater then zero.");

        return new self($new);
    }
}