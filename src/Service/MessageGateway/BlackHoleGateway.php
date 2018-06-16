<?php

declare (strict_types=1);

namespace Oxidmod\Messages\Service\MessageGateway;

/**
 * Does not send messages.
 */
class BlackHoleGateway implements GatewayInterface
{
    /**
     * @param Message $message
     *
     * @return void
     */
    public function send(Message $message): void
    {
    }
}
