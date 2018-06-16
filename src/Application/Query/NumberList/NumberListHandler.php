<?php

declare (strict_types=1);

namespace Oxidmod\Messages\Application\Query\NumberList;

use Doctrine\ORM\EntityManagerInterface;
use Oxidmod\Messages\Application\HandlerInterface;
use Oxidmod\Messages\Entity\Number;

/**
 * Handler for NumberListQuery
 */
class NumberListHandler implements HandlerInterface
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
     * @param NumberListQuery $query
     *
     * @return array
     */
    public function handle(NumberListQuery $query): array
    {
        return $this->em->createQueryBuilder()
            ->select('n')
            ->from(Number::class, 'n')
            ->getQuery()
            ->execute();
    }
}
