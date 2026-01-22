<?php

namespace App\Domain\Erros;

use Illuminate\Support\Collection;

final class DomainErrors
{
    public static function Conflict(?string $message = "The data provided conflicts with existing data.") : DomainErrors
    {
        return new DomainErrors($message, "Conflict");
    }

    public static function NotFound(?string $message = "The requested resource was not found.") : DomainErrors
    {
        return new DomainErrors($message, "NotFound");
    }
    
    public static function BadRequest(?string $message = "Invalid request or parameters."): DomainErrors
    {
        return new DomainErrors($message, "BadRequest");
    }

    public static function Validation(?string $message = "One or more validation errors occurred.", Collection $errors = null): DomainErrors
    {
        return new DomainErrors($message, "Validation");
    }
    
    public static function Unauthorized(?string $message = "Unauthorized access.") : DomainErrors
    {
        return new DomainErrors($message, "Unauthorized");
    }
    
    public static function Unexpected(?string $message = "An unexpected error occurred."): DomainErrors
    {
        return new DomainErrors($message, "Unexpected");
    }

    // Ctor is private to enforce the use of static factory methods
    private function __construct(string $message, string $type, ?Collection $errors = null)
    {
        $errorMessage = $message;
        $errorType = $type;
        $errors = $errors ?? [];
    }
    public string $errorMessage;
    public string $errorType;
    public Collection $errors;
}