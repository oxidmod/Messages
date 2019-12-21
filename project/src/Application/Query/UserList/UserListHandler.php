<?php

declare (strict_types=1);

namespace Oxidmod\Messages\Application\Query\UserList;

use Doctrine\ORM\EntityManagerInterface;
use Oxidmod\Messages\Application\HandlerInterface;
use Oxidmod\Messages\Entity\User;

/**
 * Handler for UserListQuery
 */
class UserListHandler implements HandlerInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param UserListQuery $query
     *
     * @return array
     */
    public function handle(UserListQuery $query): array
    {
        $qb = $this->em->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u');

        if ($query->onlyActive()) {
            $qb->where('u.isActive = 1');
        }

        return $qb->getQuery()->execute();
    }
}
