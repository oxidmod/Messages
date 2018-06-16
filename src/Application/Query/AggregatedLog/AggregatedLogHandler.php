<?php

declare (strict_types=1);

namespace Oxidmod\Messages\Application\Query\AggregatedLog;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
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
                \DateTimeImmutable::createFromFormat('Y-m-d 00:00:00', $row['log_date']),
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
            ->select('log_date, message_number_success, message_number_fail')
            ->from('send_log_aggregate');

        $predicates = $qb->expr()->andX();
        if ($query->hasUserId()) {
            $predicates->add($qb->expr()->eq('usr_id', $query->getUserId()));
        }

        if ($query->hasCountryId()) {
            $predicates->add($qb->expr()->eq('ctn_id', $query->getCountryId()));
        }

        $predicates->add($qb->expr()->gte('log_date', $query->getFrom()));
        $predicates->add($qb->expr()->lte('log_date', $query->getTo()));

        return $qb->where($predicates);
    }
}
