<?php

declare (strict_types=1);

namespace Oxidmod\Messages\Service\MessageGateway;

use Oxidmod\Messages\Service\MessageGateway\Exception\SendMessageException;

/**
 * Does not send messages.
 * Throw exception sometime =)
 */
class BlackHoleGateway implements GatewayInterface
{
    /**
     * {@inheritdoc}
     */
    public function send(Message $message): void
    {
        if (\random_int(0, 3) === 0) {
            throw new SendMessageException('Message was not sent.');
        }
    }
}
