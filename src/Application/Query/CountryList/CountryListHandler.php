<?php

declare (strict_types=1);

namespace Oxidmod\Messages\Application\Query\CountryList;

use Doctrine\ORM\EntityManagerInterface;
use Oxidmod\Messages\Application\HandlerInterface;
use Oxidmod\Messages\Entity\Country;

/**
 * Handler for CountryListQuery
 */
class CountryListHandler implements HandlerInterface
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
     * @param CountryListQuery $query
     *
     * @return array
     */
    public function handle(CountryListQuery $query): array
    {
        return $this->em->createQueryBuilder()
            ->select('c')
            ->from(Country::class, 'c')
            ->getQuery()
            ->execute();
    }
}
