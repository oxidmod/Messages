<?php

declare (strict_types=1);

namespace Oxidmod\Messages\Application\Query\AggregatedLog;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\DBAL\Types\Type;
use Oxidmod\Messages\Application\HandlerInterface;

/**
 * Handler AggregatedLogQuery
 */
class AggregatedLogHandler implements HandlerInterface
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param AggregatedLogQuery $query
     *
     * @return array
     */
    public function handle(AggregatedLogQuery $query): array
    {
        $results = $this->createQueryBuilder($query)->execute();

        return \array_map(function (array $row) {
            return new AggregatedLog(
                \DateTimeImmutable::createFromFormat('Y-m-d', $row['log_date']),
                (int) $row['message_number_success'],
                (int) $row['message_number_fail']
            );
        }, $results->fetchAll());
    }

    /**
     * @param AggregatedLogQuery $query
     *
     * @return QueryBuilder
     */
    private function createQueryBuilder(AggregatedLogQuery $query): QueryBuilder
    {
        $qb = (new QueryBuilder($this->connection))
            ->select('log_date, SUM(message_number_success) as message_number_success, SUM(message_number_fail) as message_number_fail')
            ->from('send_log_aggregated')
            ->where('log_date BETWEEN :date_from AND :date_to')
            ->setParameter('date_from', $query->getFrom(), Type::DATE_IMMUTABLE)
            ->setParameter('date_to', $query->getTo(), Type::DATE_IMMUTABLE)
            ->groupBy('log_date')
            ->orderBy('log_date');

        $predicates = $qb->expr()->andX();
        if ($query->hasUserId()) {
            $predicates->add($qb->expr()->eq('usr_id', $query->getUserId()));
        }

        if ($query->hasCountryId()) {
            $predicates->add($qb->expr()->eq('cnt_id', $query->getCountryId()));
        }

        if ($predicates->count() > 0) {
            $qb->andWhere($predicates);
        }

        return $qb;
    }
}
