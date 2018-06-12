<?php

declare (strict_types=1);

namespace Oxidmod\Messages\Tests\Unit;

use PHPUnit\Framework\TestCase;

class TravisCITest extends TestCase
{
    public function testTrue(): void
    {
        static::assertTrue(true);
    }
}
