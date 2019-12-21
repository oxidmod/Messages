<?php

declare (strict_types=1);

namespace Oxidmod\Messages\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Oxidmod\Messages\Entity\SendLog;

/**
 * Repository for SendLog entity
 */
class SendLogRepository
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
     * @param SendLog $log
     */
    public function save(SendLog $log): void
    {
        $this->em->persist($log);
        $this->em->flush();
    }
}
