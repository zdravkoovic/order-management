<?php 

namespace App\Domain\OrderlineAggregate;

use App\Domain\Shared\Uuid;

final class ProductId
{
    private Uuid $id;

    private function __construct(Uuid $id)
    {
        $this->id = $id;
    }

    public static function fromString(string $id) : self
    {
        return new self(Uuid::fromString($id));
    }

    public function value() : string
    {
        return $this->id->value();
    }

    public function getId() : Uuid
    {
        return $this->id;
    }
}