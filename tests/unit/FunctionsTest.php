<?php

declare(strict_types=1);

namespace Smoren\Sequence\Tests\Unit;

use Codeception\Test\Unit;

use function Smoren\Sequence\Functions\xrange;

class FunctionsTest extends Unit
{
    public function testXrange()
    {
        $range = xrange(10);
        $this->assertEquals(range(0, 9), iterator_to_array($range));

        $range = xrange(0, 10);
        $this->assertEquals(range(0, 9), iterator_to_array($range));

        $range = xrange(2, 10);
        $this->assertEquals(range(2, 11), iterator_to_array($range));

        $range = xrange(2, 3, 3);
        $this->assertEquals([2, 5, 8], iterator_to_array($range));
    }
}
