<?php

declare (strict_types=1);

namespace Oxidmod\Messages\UserInterface\Web;

use League\Tactician\CommandBus;
use Oxidmod\Messages\Application\Query\AggregatedLog\AggregatedLogQuery;
use Oxidmod\Messages\Application\Query\CountryList\CountryListQuery;
use Oxidmod\Messages\Application\Query\UserList\UserListQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Log controller
 */
class LogController extends AbstractController
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
     *     "/logs",
     *     name="get_logs",
     *     methods={"GET", "POST"}
     * )
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws BadRequestHttpException
     */
    public function __invoke(Request $request): Response
    {
        try {
            $logs = $this->getLogs($request);
        } catch (\InvalidArgumentException $exception) {
            throw new BadRequestHttpException($exception->getMessage(), $exception);
        }

        return $this->render('log/log.html.twig', [
            'users' => $this->commandBus->handle(new UserListQuery()),
            'countries' => $this->commandBus->handle(new CountryListQuery()),
            'logs' => $logs,
        ]);
    }

    /**
     * @param Request $request
     *
     * @return array
     *
     * @throws \InvalidArgumentException
     */
    private function getLogs(Request $request): array
    {
        $logs = [];
        if ($request->isMethod('post')) {
            $logs = $this->commandBus->handle(
                new AggregatedLogQuery(
                    $request->request->get('from', ''),
                    $request->request->get('to', ''),
                    empty($request->request->get('userId')) ? null : (int) $request->request->get('userId'),
                    empty($request->request->get('countryId')) ? null : (int) $request->request->get('countryId')
                )
            );
        }

        return $logs;
    }
}
