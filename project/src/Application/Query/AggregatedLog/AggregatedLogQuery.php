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
     * @param string   $from
     * @param string   $to
     * @param int|null $userId
     * @param int|null $countryId
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(
        string $from,
        string $to,
        ? int $userId,
        ? int $countryId
    ) {
        $this->setFrom($from);
        $this->setTo($to);
        $this->validateDates();

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
    public function getTo() : \DateTimeImmutable
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

    /**
     * @param string $from
     *
     * @throws \InvalidArgumentException
     */
    public function setFrom(string $from): void
    {
        $date = \DateTimeImmutable::createFromFormat('Y-m-d', $from);

        if (false === $date) {
            throw new \InvalidArgumentException(
                \sprintf('DateFrom "%s" is invalid.', $from)
            );
        }

        $this->from = $date->setTime(0, 0);
    }

    /**
     * @param string $to
     *
     * @throws \InvalidArgumentException
     */
    public function setTo(string $to): void
    {
        $date = \DateTimeImmutable::createFromFormat('Y-m-d', $to);

        if (false === $date) {
            throw new \InvalidArgumentException(
                \sprintf('DateTo "%s" is invalid.', $to)
            );
        }

        $this->to = $date->setTime(0, 0);
    }

    /**
     * @throws \InvalidArgumentException
     */
    private function validateDates(): void
    {
        if ($this->to < $this->from) {
            throw new \InvalidArgumentException('DateFrom can\'t be greater then DateTo.');
        }
    }
}
