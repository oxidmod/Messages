<?php

namespace Oxidmod\Messages\Service\MessageGateway;

/**
 * Interface for gateway which can sent a message
 */
interface GatewayInterface
{
    /**
     * @param Message $message
     *
     * @throws \Exception
     */
    public function send(Message $message): void;
}
