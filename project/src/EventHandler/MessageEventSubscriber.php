<?php

declare (strict_types=1);

namespace Oxidmod\Messages\EventHandler;

use Oxidmod\Messages\Entity\SendLog;
use Oxidmod\Messages\Event\MessageNotSentEvent;
use Oxidmod\Messages\Event\MessageSentEvent;
use Oxidmod\Messages\Repository\NumberRepository;
use Oxidmod\Messages\Repository\SendLogRepository;
use Oxidmod\Messages\Repository\UserRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Create logs with sent message info
 */
class MessageEventSubscriber implements EventSubscriberInterface
{
    /**
     * @var UserRepository
     */
    private $userRepo;

    /**
     * @var NumberRepository
     */
    private $numberRepo;

    /**
     * @var SendLogRepository
     */
    private $logRepo;

    /**
     * @param UserRepository    $userRepo
     * @param NumberRepository  $numberRepo
     * @param SendLogRepository $logRepo
     */
    public function __construct(UserRepository $userRepo, NumberRepository $numberRepo, SendLogRepository $logRepo)
    {
        $this->userRepo = $userRepo;
        $this->numberRepo = $numberRepo;
        $this->logRepo = $logRepo;
    }

    /**
     * @param MessageSentEvent $event
     */
    public function onMessageSent(MessageSentEvent $event): void
    {
        $this->logRepo->save(
            SendLog::logSuccess(
                $this->userRepo->find($event->getUserId()),
                $this->numberRepo->find($event->getNumberId()),
                $event->getMessage()
            )
        );
    }

    /**
     * @param MessageNotSentEvent $event
     */
    public function onMessageNotSent(MessageNotSentEvent $event): void
    {
        $this->logRepo->save(
            SendLog::logFail(
                $this->userRepo->find($event->getUserId()),
                $this->numberRepo->find($event->getNumberId()),
                $event->getMessage()
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            MessageSentEvent::class => [
                ['onMessageSent', 0],
            ],
            MessageNotSentEvent::class => [
                ['onMessageNotSent', 0],
            ],
        ];
    }
}
