<?php

declare (strict_types=1);

namespace Oxidmod\Messages\Event;

/**
 * This event is triggered on message sending fail
 */
class MessageNotSentEvent
{
    public const EVENT_NAME = 'messages.event_not_sent';

    /**
     * @var int
     */
    private $userId;

    /**
     * @var int
     */
    private $numberId;

    /**
     * @var string
     */
    private $message;

    /**
     * @param int    $userId
     * @param int    $numberId
     * @param string $message
     */
    public function __construct(int $userId, int $numberId, string $message)
    {
        $this->userId = $userId;
        $this->numberId = $numberId;
        $this->message = $message;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return int
     */
    public function getNumberId(): int
    {
        return $this->numberId;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}
