<?php

namespace App\Application\Abstraction;

// It would be nice to implement Result pattern
interface ICommand
{
    public function commandId() : string;
    public function toLogContext() : array;
}