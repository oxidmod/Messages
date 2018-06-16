<?php

declare (strict_types=1);

namespace Oxidmod\Messages\Command\AggregateLog;

use Doctrine\DBAL\Driver\Connection;
use Oxidmod\Messages\Command\HandlerInterface;
use Psr\Log\LoggerInterface;

/**
 * Handler for AggregateLogCommand
 */
class AggregateLogHandler implements HandlerInterface
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param Connection      $connection
     * @param LoggerInterface $logger
     */
    public function __construct(Connection $connection, LoggerInterface $logger)
    {
        $this->connection = $connection;
        $this->logger = $logger;
    }

    /**
     * @param AggregateLogCommand $command
     *
     * @throws \Exception
     */
    public function handle(AggregateLogCommand $command): void
    {
        try {
            $this->lock();

            $this->clearAggregatedInfo();
            $this->aggregate();

            if ($command->needToClearLog()) {
                $this->clearAllLogs();
            }
        } catch (\Exception $exception) {
            $this->logError($exception);

            throw $exception;
        } finally {
            $this->unlock();
        }
    }

    /**
     * Delete all records from aggregated table
     */
    private function clearAggregatedInfo(): void
    {
        $this->connection->exec('DELETE FROM send_log_aggregated;');
    }

    /**
     * Collect aggregated info
     */
    private function aggregate(): void
    {
        $this->connection->exec('
            INSERT INTO send_log_aggregated (usr_id, cnt_id, log_date, message_number_success, message_number_fail)
            SELECT 
                send_log.usr_id as usr_id,
                numbers.cnt_id as cnt_id,
                DATE(send_log.log_created) as log_date,
                COUNT(
                    CASE 
                        WHEN send_log.`log_success`=1 THEN 1 
                        ELSE NULL 
                    END
                ) as message_number_success,
                COUNT(
                    CASE 
                        WHEN send_log.`log_success`=0 THEN 1
                        ELSE NULL
                    END
                ) as message_number_fail
            FROM send_log JOIN numbers ON send_log.num_id=numbers.num_id
            GROUP BY send_log.usr_id, numbers.cnt_id, log_date;
        ');
    }

    /**
     * Clear all logs
     */
    private function clearAllLogs(): void
    {
        $this->connection->exec('DELETE FROM send_log');
    }

    /**
     * Lock log table
     */
    private function lock(): void
    {
        $this->connection->exec('LOCK TABLES send_log WRITE, numbers WRITE, send_log_aggregated WRITE;');
    }

    /**
     * Unlock locked tables
     */
    private function unlock(): void
    {
        $this->connection->exec('UNLOCK TABLES;');
    }

    /**
     * @param \Throwable $error
     */
    private function logError(\Throwable $error): void
    {
        $this->logger->critical('Aggregated info can\'t be collected.', [
            'Message' => $error->getMessage(),
        ]);
    }
}
