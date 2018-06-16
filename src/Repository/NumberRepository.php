<?php

declare(strict_types=1);

namespace Oxidmod\Messages\Repository;

use Oxidmod\Messages\Entity\Number;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Number|null find(int $id, int $lockMode = null, int $lockVersion = null)
 * @method Number|null findOneBy(array $criteria, array $orderBy = null)
 * @method Number[]    findAll()
 * @method Number[]    findBy(array $criteria, array $orderBy = null, int $limit = null, int $offset = null)
 */
class NumberRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Number::class);
    }
}
