<?php

declare (strict_types=1);

namespace Oxidmod\Messages\Tests\Unit\Application\Query\AggregatedLog;

use Oxidmod\Messages\Application\Query\AggregatedLog\AggregatedLogQuery;
use PHPUnit\Framework\TestCase;

/**
 * Test for AggregatedLogQuery
 */
class AggregatedLogQueryTest extends TestCase
{
    public function testConstructWithDates(): void
    {
        $query = new AggregatedLogQuery('2018-06-01', '2018-06-10', null, null);

        static::assertEquals('2018-06-01 00:00:00', $query->getFrom()->format('Y-m-d H:i:s'));
        static::assertEquals('2018-06-10 00:00:00', $query->getTo()->format('Y-m-d H:i:s'));
        static::assertFalse($query->hasUserId());
        static::assertFalse($query->hasCountryId());
    }

    public function testConstructWithUserId(): void
    {
        $query = new AggregatedLogQuery('2018-06-01', '2018-06-10', 123, null);

        static::assertTrue($query->hasUserId());
        static::assertEquals(123, $query->getUserId());
    }

    public function testConstructWithCountryId(): void
    {
        $query = new AggregatedLogQuery('2018-06-01', '2018-06-10', null, 456);

        static::assertTrue($query->hasCountryId());
        static::assertEquals(456, $query->getCountryId());
    }

    /**
     * @param string $from
     * @param string $to
     * @param string $expectedMessage
     *
     * @expectedException \InvalidArgumentException
     *
     * @dataProvider providerConstructException
     */
    public function testConstructException(string $from, string $to, string $expectedMessage): void
    {
        $this->expectExceptionMessage($expectedMessage);

        new AggregatedLogQuery($from, $to, null, null);
    }

    /**
     * @return array
     */
    public function providerConstructException(): array
    {
        return [
            ['123', '2018-06-10', 'DateFrom "123" is invalid.'],
            ['2018-06-10', '123', 'DateTo "123" is invalid.'],
            ['2018-06-10', '2018-06-01', 'DateFrom can\'t be greater then DateTo.'],
        ];
    }
}
