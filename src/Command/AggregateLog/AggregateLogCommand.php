<?php

declare (strict_types=1);

namespace Oxidmod\Messages\Command\AggregateLog;

/**
 * Application command to aggregate send log
 */
class AggregateLogCommand
{
    /**
     * @var bool
     */
    private $needToClearLog;

    /**
     * @return AggregateLogCommand
     */
    public static function clearLog(): self
    {
        return new self(true);
    }

    /**
     * @return AggregateLogCommand
     */
    public static function preserveLog(): self
    {
        return new self(false);
    }

    /**
     * @return bool
     */
    public function needToClearLog(): bool
    {
        return $this->needToClearLog;
    }

    /**
     * @param bool $needToClearLog
     */
    private function __construct(bool $needToClearLog)
    {
        $this->needToClearLog = $needToClearLog;
    }
}
