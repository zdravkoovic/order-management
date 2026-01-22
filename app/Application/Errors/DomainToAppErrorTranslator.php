<?php

namespace App\Application\Errors;

use App\Application\Errors\Contracts\ErrorTranslator;
use App\Domain\OrderAggregate\Errors\CustomerNotFoundException;
use App\Domain\OrderAggregate\Errors\OrderExpirationTimeViolated;
use App\Domain\OrderAggregate\Errors\PaymentMethodUndefinedException;
use App\Domain\OrderAggregate\Errors\ReferenceUndefinedException;
use App\Domain\OrderAggregate\Errors\TotalAmountViolationException;
use Throwable;

final class DomainToAppErrorTranslator implements ErrorTranslator
{
    public function translate(Throwable $e): ?AppError
    {
        return match (true) {
            $e instanceof PaymentMethodUndefinedException => 
                new AppError(
                    'ORDER.MISSING_PAYMENT',
                    'Payment method is required to complete your order.',
                    422
                ),
            $e instanceof TotalAmountViolationException => 
                new AppError(
                    'ORDER.TOTAL_AMOUNT_ZERO',
                    'You must have at least one ordered product to be able to order.',
                    422
                ),
            $e instanceof OrderExpirationTimeViolated =>
                new AppError(
                    'ORDER.EXPIRED',
                    'Your order is expired. Create new one.',
                    409
                ),
            $e instanceof ReferenceUndefinedException => 
                new AppError(
                    'ORDER.REFERENCE_MISSING',
                    'Order reference is missing and the operation cannot be completed.',
                    422
                ),
            $e instanceof CustomerNotFoundException => 
                new AppError(
                    'CUSTOMER.CUSTOMER_NOT_FOUND',
                    'Customer not found.',
                    404
                ),
            default => null,
        };
    }
}