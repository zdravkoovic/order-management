<?php

namespace App\Application\Events\Handlers;

use App\Domain\OrderAggregate\Events\OrderCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendEmailNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCreated $event): void
    {
        echo "Sending email notification for Order ID: " . $event->order->id->value() . "\n";
    }
}
