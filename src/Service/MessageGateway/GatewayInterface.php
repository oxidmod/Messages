<?php

namespace Oxidmod\Messages\Service\MessageGateway;


interface GatewayInterface
{
    public function send(Message $message): void;
}