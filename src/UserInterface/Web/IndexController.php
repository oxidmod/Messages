<?php

declare (strict_types=1);

namespace Oxidmod\Messages\UserInterface\Web;

use League\Tactician\CommandBus;
use Oxidmod\Messages\Application\Query\NumberList\NumberListQuery;
use Oxidmod\Messages\Application\Query\UserList\UserListQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Index controller
 */
class IndexController extends AbstractController
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
     *     "/",
     *     name="index",
     *     methods={"GET"}
     * )
     *
     * @return Response
     */
    public function __invoke(): Response
    {
        return $this->render('index/index.html.twig', [
            'users' => $this->commandBus->handle(new UserListQuery()),
            'numbers' => $this->commandBus->handle(new NumberListQuery()),
        ]);
    }
}
