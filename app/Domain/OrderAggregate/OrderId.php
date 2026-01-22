<?php

namespace App\Domain\OrderAggregate;

use App\Domain\Shared\Uuid;

final class OrderId
{
    private Uuid $id;

    private function __construct(Uuid $id)
    {
        $this->id = $id;
    }

    public static function generate(): self
    {
        return new self(Uuid::generate());
    }

    public static function fromString(string $value): self
    {
        return new self(Uuid::fromString($value));
    }

    public function value(): string
    {
        return $this->id->value();
    }

    public function getId() : Uuid
    {
        return $this->id;
    }

    public function equals(self $other): bool
    {
        return $this->id->equals($other->id);
    }
}