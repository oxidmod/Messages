<?php

declare (strict_types=1);

namespace Oxidmod\Messages\UserInterface\Web;

use League\Tactician\CommandBus;
use Oxidmod\Messages\Application\Command\SendMessage\SendMessageCommand;
use Oxidmod\Messages\Repository\Exception\NumberNotFoundException;
use Oxidmod\Messages\Repository\Exception\UserNotFoundException;
use Oxidmod\Messages\Service\MessageGateway\Exception\SendMessageException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Send message controller
 */
class SendMessageController extends Controller
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @Route(
     *     "/users/{userId}/message",
     *     requirements={"userId" = "\d+"},
     *     name="send_message",
     *     methods={"POST"}
     * )
     *
     * @param int     $userId
     * @param Request $request
     *
     * @return Response
     *
     * @throws ServiceUnavailableHttpException
     * @throws NotFoundHttpException
     */
    public function __invoke(int $userId, Request $request): Response
    {
        $command = new SendMessageCommand(
            $userId,
            $request->request->getInt('numberId'),
            $request->request->get('message')
        );

        try {
            $this->commandBus->handle($command);
        } catch (UserNotFoundException | NumberNotFoundException $exception) {
            throw new NotFoundHttpException($exception->getMessage(), $exception);
        } catch (SendMessageException $exception) {
            throw new ServiceUnavailableHttpException(null, $exception->getMessage(), $exception);
        }

        return $this->json([
            'message' => 'Message was successfuly sent.',
        ]);
    }
}
