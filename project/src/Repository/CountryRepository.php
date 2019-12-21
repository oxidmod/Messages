<?php

declare(strict_types=1);

namespace Oxidmod\Messages\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Oxidmod\Messages\Entity\Country;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Country|null find(int $id, int $lockMode = null, int $lockVersion = null)
 * @method Country|null findOneBy(array $criteria, array $orderBy = null)
 * @method Country[]    findAll()
 * @method Country[]    findBy(array $criteria, array $orderBy = null, int $limit = null, int $offset = null)
 */
class CountryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Country::class);
    }
}
