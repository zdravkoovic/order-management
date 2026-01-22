<?php

namespace App\Application\Command;

use App\Application\Errors\AppError;
use App\Domain\Shared\Uuid;

final class CommandResult
{
    private function __construct(
        public bool $success,
        public ?Uuid $id = null,
        public ?AppError $appError = null
    ){} 

    public static function success(Uuid $id) : self
    {
        return new self(true, $id);
    }

    public static function fail(AppError $appError) : self
    {
        return new self(false, null, $appError);
    }
}