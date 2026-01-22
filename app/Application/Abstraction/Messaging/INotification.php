<?php

namespace App\Application\Abstraction\Messaging;

interface INotification
{
    public function sendNotification(array $data);

}