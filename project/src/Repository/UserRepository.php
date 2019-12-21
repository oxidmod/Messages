<?php

declare (strict_types=1);

namespace Oxidmod\Messages\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Oxidmod\Messages\Entity\User;
use Oxidmod\Messages\Repository\Exception\UserNotFoundException;

/**
 * Repository for User entity
 */
class UserRepository
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
     * @param int $userId
     *
     * @return User
     *
     * @throws UserNotFoundException
     */
    public function find(int $userId): User
    {
        $entity = $this->em->find(User::class, $userId);

        if ($entity instanceof User) {
            return $entity;
        }

        throw new UserNotFoundException($userId);
    }
}
