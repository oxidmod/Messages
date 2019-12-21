<?php

declare (strict_types=1);

namespace Oxidmod\Messages\Application\Query\AggregatedLog;

/**
 * Represent aggregated log
 */
class AggregatedLog
{
    /**
     * @var \DateTimeImmutable
     */
    private $date;

    /**
     * @var int
     */
    private $successNumber;

    /**
     * @var int
     */
    private $failNumber;

    /**
     * @param \DateTimeImmutable $date
     * @param int                $successNumber
     * @param int                $failNumber
     */
    public function __construct(\DateTimeImmutable $date, int $successNumber, int $failNumber)
    {
        $this->date = $date;
        $this->successNumber = $successNumber;
        $this->failNumber = $failNumber;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * @return int
     */
    public function getSuccessNumber(): int
    {
        return $this->successNumber;
    }

    /**
     * @return int
     */
    public function getFailNumber(): int
    {
        return $this->failNumber;
    }
}
