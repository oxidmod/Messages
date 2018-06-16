<?php

declare (strict_types=1);

namespace Oxidmod\Messages\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Oxidmod\Messages\Entity\Number;
use Oxidmod\Messages\Repository\Exception\NumberNotFoundException;

/**
 * Repository for Number entity
 */
class NumberRepository
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
     * @param int $numberId
     *
     * @return Number
     *
     * @throws NumberNotFoundException
     */
    public function find(int $numberId): Number
    {
        $entity = $this->em->find(Number::class, $numberId);

        if ($entity instanceof Number) {
            return $entity;
        }

        throw new NumberNotFoundException($numberId);
    }
}
