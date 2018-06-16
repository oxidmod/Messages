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
     *     "/message",
     *     name="send_message",
     *     methods={"POST"}
     * )
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws ServiceUnavailableHttpException
     * @throws NotFoundHttpException
     */
    public function __invoke(Request $request): Response
    {
        $command = new SendMessageCommand(
            $request->request->getInt('userId'),
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

        return $this->redirectToRoute('index');
    }
}
