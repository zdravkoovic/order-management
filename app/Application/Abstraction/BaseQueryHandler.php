<?php

namespace App\Application\Abstraction;

abstract class BaseQueryHandler implements IQueryHandler
{
    public function __construct() {}
    
    public function handle(IQuery $query) : Dto
    {
        $result = $this->execute($query);
        return $result;
    }

    abstract function execute(IQuery $query) : ?Dto;
}