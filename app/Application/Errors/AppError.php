<?php

namespace App\Application\Errors;

final class AppError
{
    public function __construct(
        public string $code,
        public string $userMessage,
        public int $httpStatus = 400,
        public ?array $details = null
    ){}
}