<?php

namespace App\Application\Errors\Contracts;

use App\Application\Errors\AppError;

interface ErrorTranslator
{
    public function translate(\Throwable $e): ?AppError;
}