<?php

declare (strict_types=1);

namespace Oxidmod\Messages\UserInterface\Web;

use League\Tactician\CommandBus;
use Oxidmod\Messages\Application\Command\SendMessage\SendMessageCommand;
use Oxidmod\Messages\Application\Query\NumberList\NumberListQuery;
use Oxidmod\Messages\Application\Query\UserList\UserListQuery;
use Oxidmod\Messages\Repository\Exception\NumberNotFoundException;
use Oxidmod\Messages\Repository\Exception\UserNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Send message controller
 */
class SendMessageController extends AbstractController
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
     *     methods={"POST", "GET"}
     * )
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws NotFoundHttpException
     */
    public function __invoke(Request $request): Response
    {
        if ($request->isMethod('post')) {
            $this->handleRequest($request);
        }

        return $this->render('message/message.html.twig', [
            'users' => $this->commandBus->handle(new UserListQuery()),
            'numbers' => $this->commandBus->handle(new NumberListQuery()),
        ]);
    }

    /**
     * @param Request $request
     *
     * @throws NotFoundHttpException
     */
    private function handleRequest(Request $request): void
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
        }
    }
}
