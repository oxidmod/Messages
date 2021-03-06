<?php

declare (strict_types=1);

namespace Oxidmod\Messages\Application\Command\SendMessage;

use Oxidmod\Messages\Application\HandlerInterface;
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

/**
 * Handler for SendMessageCommand
 */
class SendMessageHandler implements HandlerInterface
{
    /**
     * @var UserRepository
     */
    private $userRepo;

    /**
     * @var NumberRepository
     */
    private $numbersRepo;

    /**
     * @var GatewayInterface
     */
    private $messageGateway;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @param UserRepository           $userRepo
     * @param NumberRepository         $numbersRepo
     * @param GatewayInterface         $messageGateway
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(
        UserRepository $userRepo,
        NumberRepository $numbersRepo,
        GatewayInterface $messageGateway,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->userRepo = $userRepo;
        $this->numbersRepo = $numbersRepo;
        $this->messageGateway = $messageGateway;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param SendMessageCommand $command
     *
     * @throws UserNotFoundException
     * @throws NumberNotFoundException
     */
    public function handle(SendMessageCommand $command): void
    {
        $this->checkIfUserExists($command->getUserId());
        $number = $this->getNumber($command->getNumberId());

        try {
            $this->messageGateway->send(
                new Message($number, $command->getMessage())
            );

            $this->eventDispatcher->dispatch(
                new MessageSentEvent($command->getUserId(), $command->getNumberId(), $command->getMessage())
            );
        } catch (SendMessageException $exception) {
            $this->eventDispatcher->dispatch(
                new MessageNotSentEvent($command->getUserId(), $command->getNumberId(), $command->getMessage())
            );
        }
    }

    /**
     * @param int $userId
     *
     * @throws UserNotFoundException
     */
    private function checkIfUserExists(int $userId): void
    {
        $this->userRepo->find($userId);
    }

    /**
     * @param int $numberId
     *
     * @return string
     *
     * @throws NumberNotFoundException
     */
    private function getNumber(int $numberId): string
    {
        return $this->numbersRepo
            ->find($numberId)
            ->getNumber();
    }
}
