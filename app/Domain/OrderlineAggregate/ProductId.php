<?php 

namespace App\Domain\OrderlineAggregate;

use App\Domain\Shared\Uuid;

final class ProductId
{
    public readonly Uuid $id;

    private function __construct(Uuid $id)
    {
        $this->id = $id;
    }

    public static function fromString(string $id) : self
    {
        return new self(Uuid::fromString($id));
    }
}