<?php

declare(strict_types=1);

namespace Oxidmod\Messages\Repository;

use Oxidmod\Messages\Entity\SendLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SendLog|null find(int $id, int $lockMode = null, int $lockVersion = null)
 * @method SendLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method SendLog[]    findAll()
 * @method SendLog[]    findBy(array $criteria, array $orderBy = null, int $limit = null, int $offset = null)
 */
class SendLogRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SendLog::class);
    }
}
