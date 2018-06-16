<?php

declare (strict_types=1);

namespace Oxidmod\Messages\Application\Query\AggregatedLog;

/**
 *  Contains query params
 */
class AggregatedLogQuery
{
    /**
     * @var \DateTimeImmutable
     */
    private $from;

    /**
     * @var \DateTimeImmutable
     */
    private $to;

    /**
     * @var int|null
     */
    private $userId;

    /**
     * @var int|null
     */
    private $countryId;

    /**
     * @param \DateTimeImmutable $from
     * @param \DateTimeImmutable $to
     * @param int|null           $userId
     * @param int|null           $countryId
     */
    public function __construct(
        \DateTimeImmutable $from,
        \DateTimeImmutable $to,
        ? int $userId,
        ? int $countryId
    ) {
        $this->from = $from;
        $this->to = $to;
        $this->userId = $userId;
        $this->countryId = $countryId;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getFrom() : \DateTimeImmutable
    {
        return $this->from;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getTo(): \DateTimeImmutable
    {
        return $this->to;
    }

    /**
     * @return bool
     */
    public function hasUserId(): bool
    {
        return null !== $this->userId;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return bool
     */
    public function hasCountryId(): bool
    {
        return null !== $this->countryId;
    }

    /**
     * @return int
     */
    public function getCountryId(): int
    {
        return $this->countryId;
    }
}
