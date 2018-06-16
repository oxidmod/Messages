<?php

declare (strict_types=1);

namespace Oxidmod\Messages\Tests\Unit;

use Oxidmod\Messages\Command\SendMessage\SendMessageCommand;
use Oxidmod\Messages\Command\SendMessage\SendMessageHandler;
use Oxidmod\Messages\Entity\Country;
use Oxidmod\Messages\Entity\Number;
use Oxidmod\Messages\Entity\User;
use Oxidmod\Messages\Event\MessageNotSentEvent;
use Oxidmod\Messages\Event\MessageSentEvent;
use Oxidmod\Messages\Repository\Exception\NumberNotFoundException;
use Oxidmod\Messages\Repository\Exception\UserNotFoundException;
use Oxidmod\Messages\Repository\NumberRepository;
use Oxidmod\Messages\Repository\UserRepository;
use Oxidmod\Messages\Service\MessageGateway\Exception\SendMessageException;
use Oxidmod\Messages\Service\MessageGateway\GatewayInterface;
use Oxidmod\Messages\Service\MessageGateway\Message;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use PHPUnit\Framework\TestCase;

/**
 * Test for SendMessageHandler
 */
class SendMessageHandlerTest extends TestCase
{
    private const USER_ID = 123;
    private const NUMBER_ID = 234;
    private const NUMBER = '+380934501908';
    private const MESSAGE = 'Hello world!';

    /**
     * @var UserRepository|\PHPUnit_Framework_MockObject_MockObject
     */
    private $userRepo;

    /**
     * @var NumberRepository|\PHPUnit_Framework_MockObject_MockObject
     */
    private $numbersRepo;

    /**
     * @var GatewayInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $messageGateway;

    /**
     * @var EventDispatcherInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $eventDispatcher;

    /**
     * @var SendMessageHandler
     */
    private $handler;

    public function testHandle(): void
    {
        $command = new SendMessageCommand(self::USER_ID, self::NUMBER_ID, self::MESSAGE);

        $this->userRepo->expects(static::once())
            ->method('find')
            ->with(self::USER_ID)
            ->willReturn($this->createMock(User::class));

        $this->numbersRepo->expects(static::once())
            ->method('find')
            ->with(self::NUMBER_ID)
            ->willReturn(new Number($this->createMock(Country::class), self::NUMBER));

        $this->messageGateway->expects(static::once())
            ->method('send')
            ->with(new Message(self::NUMBER, self::MESSAGE));

        $this->eventDispatcher->expects(static::once())
            ->method('dispatch')
            ->with(MessageSentEvent::EVENT_NAME, new MessageSentEvent(self::USER_ID, self::NUMBER_ID, self::MESSAGE));

        $this->handler->handle($command);
    }

    public function testHandleExceptionIfUserNotFound(): void
    {
        $command = new SendMessageCommand(self::USER_ID, self::NUMBER_ID, self::MESSAGE);

        $this->userRepo->expects(static::once())
            ->method('find')
            ->with(self::USER_ID)
            ->willThrowException(new UserNotFoundException(self::USER_ID));

        $this->eventDispatcher->expects(static::once())
            ->method('dispatch')
            ->with(MessageNotSentEvent::EVENT_NAME, new MessageNotSentEvent(self::USER_ID, self::NUMBER_ID, self::MESSAGE));

        $this->expectException(UserNotFoundException::class);

        $this->handler->handle($command);
    }

    public function testHandleExceptionIfNumberNotFound(): void
    {
        $command = new SendMessageCommand(self::USER_ID, self::NUMBER_ID, self::MESSAGE);

        $this->userRepo->expects(static::once())
            ->method('find')
            ->with(self::USER_ID)
            ->willReturn($this->createMock(User::class));

        $this->numbersRepo->expects(static::once())
            ->method('find')
            ->with(self::NUMBER_ID)
            ->willReturn(new Number($this->createMock(Country::class), self::NUMBER));

        $this->messageGateway->expects(static::once())
            ->method('send')
            ->willThrowException(new SendMessageException());

        $this->eventDispatcher->expects(static::once())
            ->method('dispatch')
            ->with(MessageNotSentEvent::EVENT_NAME, new MessageNotSentEvent(self::USER_ID, self::NUMBER_ID, self::MESSAGE));

        $this->expectException(SendMessageException::class);

        $this->handler->handle($command);
    }

    public function testHandleExceptionIfMessageNotSent(): void
    {
        $command = new SendMessageCommand(self::USER_ID, self::NUMBER_ID, self::MESSAGE);

        $this->userRepo->expects(static::once())
            ->method('find')
            ->with(self::USER_ID)
            ->willReturn($this->createMock(User::class));

        $this->numbersRepo->expects(static::once())
            ->method('find')
            ->with(self::NUMBER_ID)
            ->willThrowException(new NumberNotFoundException(self::NUMBER_ID));

        $this->eventDispatcher->expects(static::once())
            ->method('dispatch')
            ->with(MessageNotSentEvent::EVENT_NAME, new MessageNotSentEvent(self::USER_ID, self::NUMBER_ID, self::MESSAGE));

        $this->expectException(NumberNotFoundException::class);

        $this->handler->handle($command);
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->userRepo = $this->createMock(UserRepository::class);
        $this->numbersRepo = $this->createMock(NumberRepository::class);
        $this->messageGateway = $this->createMock(GatewayInterface::class);
        $this->eventDispatcher = $this->createMock(EventDispatcherInterface::class);

        $this->handler = new SendMessageHandler($this->userRepo, $this->numbersRepo, $this->messageGateway, $this->eventDispatcher);
    }
}
