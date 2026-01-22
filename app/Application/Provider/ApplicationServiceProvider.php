<?php

namespace App\Application\Provider;

use App\Application\Errors\Contracts\ErrorTranslator;
use App\Application\Errors\DomainToAppErrorTranslator;
use Illuminate\Support\ServiceProvider;

class ApplicationServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ErrorTranslator::class, DomainToAppErrorTranslator::class);
    }
}