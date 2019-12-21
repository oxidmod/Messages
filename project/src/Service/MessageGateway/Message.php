<?php

declare (strict_types=1);

namespace Oxidmod\Messages\Service\MessageGateway;

/**
 * Message which should be sent
 */
class Message
{
    /**
     * @var string
     */
    private $number;

    /**
     * @var string
     */
    private $message;

    /**
     * @param string $number
     * @param string $message
     */
    public function __construct(string $number, string $message)
    {
        $this->number = $number;
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}
