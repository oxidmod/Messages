<?php

declare (strict_types=1);

namespace Oxidmod\Messages\Tests\Unit\EventHandler;

use Oxidmod\Messages\Entity\Number;
use Oxidmod\Messages\Entity\SendLog;
use Oxidmod\Messages\Entity\User;
use Oxidmod\Messages\Event\MessageNotSentEvent;
use Oxidmod\Messages\Event\MessageSentEvent;
use Oxidmod\Messages\EventHandler\MessageEventSubscriber;
use Oxidmod\Messages\Repository\NumberRepository;
use Oxidmod\Messages\Repository\SendLogRepository;
use Oxidmod\Messages\Repository\UserRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Test for MessageEventSubscriber
 */
class MessageEventSubscriberTest extends TestCase
{
    private const USER_ID = 123;
    private const NUMBER_ID = 56567;
    private const MESSAGE = 'Hello world';

    /**
     * @var UserRepository|\PHPUnit_Framework_MockObject_MockObject
     */
    private $userRepo;

    /**
     * @var NumberRepository|\PHPUnit_Framework_MockObject_MockObject
     */
    private $numberRepo;

    /**
     * @var SendLogRepository|\PHPUnit_Framework_MockObject_MockObject
     */
    private $logRepo;

    /**
     * @var MessageEventSubscriber
     */
    private $subscriber;

    public function testGetSubscribedEvents(): void
    {
        static::assertEquals([
            MessageSentEvent::class => [
                ['onMessageSent', 0],
            ],
            MessageNotSentEvent::class => [
                ['onMessageNotSent', 0],
            ],
        ], MessageEventSubscriber::getSubscribedEvents());
    }

    public function testOnMessageSent(): void
    {
        $event = new MessageSentEvent(self::USER_ID, self::NUMBER_ID, self::MESSAGE);

        $user = $this->createMock(User::class);
        $this->userRepo->expects(static::once())
            ->method('find')
            ->with(self::USER_ID)
            ->willReturn($user);

        $number = $this->createMock(Number::class);
        $this->numberRepo->expects(static::once())
            ->method('find')
            ->with(self::NUMBER_ID)
            ->willReturn($number);

        $this->logRepo->expects(static::once())
            ->method('save')
            ->with(static::isInstanceOf(SendLog::class))
            ->willReturnCallback(function (SendLog $log) use ($user, $number) {
                static::assertSame($user, $log->getUser());
                static::assertSame($number, $log->getNumber());
                static::assertSame(self::MESSAGE, $log->getMessage());
                static::assertTrue($log->isSuccess());

                return;
            });

        $this->subscriber->onMessageSent($event);
    }

    public function testOnMessageNotSent(): void
    {
        $event = new MessageNotSentEvent(self::USER_ID, self::NUMBER_ID, self::MESSAGE);

        $user = $this->createMock(User::class);
        $this->userRepo->expects(static::once())
            ->method('find')
            ->with(self::USER_ID)
            ->willReturn($user);

        $number = $this->createMock(Number::class);
        $this->numberRepo->expects(static::once())
            ->method('find')
            ->with(self::NUMBER_ID)
            ->willReturn($number);

        $this->logRepo->expects(static::once())
            ->method('save')
            ->with(static::isInstanceOf(SendLog::class))
            ->willReturnCallback(function (SendLog $log) use ($user, $number) {
                static::assertSame($user, $log->getUser());
                static::assertSame($number, $log->getNumber());
                static::assertSame(self::MESSAGE, $log->getMessage());
                static::assertFalse($log->isSuccess());

                return;
            });

        $this->subscriber->onMessageNotSent($event);
    }

    /**
     * {@inheritdoc}
     */
    protected function assertPreConditions()
    {
        static::assertInstanceOf(EventSubscriberInterface::class, $this->subscriber);
    }

    protected function setUp()
    {
        $this->userRepo = $this->createMock(UserRepository::class);
        $this->numberRepo = $this->createMock(NumberRepository::class);
        $this->logRepo = $this->createMock(SendLogRepository::class);

        $this->subscriber = new MessageEventSubscriber($this->userRepo, $this->numberRepo, $this->logRepo);
    }
}
