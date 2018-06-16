<?php

namespace Oxidmod\Messages\Service\MessageGateway;

use Oxidmod\Messages\Service\MessageGateway\Exception\SendMessageException;

/**
 * Interface for gateway which can sent a message
 */
interface GatewayInterface
{
    /**
     * @param Message $message
     *
     * @throws SendMessageException
     */
    public function send(Message $message): void;
}
