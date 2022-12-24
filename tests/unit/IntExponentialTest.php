<?php

declare(strict_types=1);

namespace Smoren\Sequence\Tests\Unit;

use Codeception\Test\Unit;
use Smoren\Sequence\Exceptions\OutOfRangeException;
use Smoren\Sequence\Exceptions\ReadOnlyException;
use Smoren\Sequence\Structs\IntExponential;

class IntExponentialTest extends Unit
{
    public function testSimple()
    {
        $range = new IntExponential(0, 3, 1);
        $this->assertCount(3, $range);
        $this->assertFalse($range->isInfinite());

        $this->assertEquals(0, $range[0]);
        $this->assertEquals(0, $range[1]);
        $this->assertEquals(0, $range[2]);
        $this->checkIsOffsetOutOfRange($range, 3);

        $this->assertEquals(0, $range[-1]);
        $this->assertEquals(0, $range[-2]);
        $this->assertEquals(0, $range[-3]);
        $this->checkIsOffsetOutOfRange($range, -4);

        $this->checkIsOffsetOutOfRange($range, null);
        $this->checkIsOffsetOutOfRange($range, 'test');
        $this->checkIsOffsetOutOfRange($range, '');
        $this->checkIsOffsetOutOfRange($range, 10.5);
        $this->checkIsOffsetOutOfRange($range, '10');

        try {
            $range[0] = 1;
            $this->fail();
        } catch(ReadOnlyException $e) {
        }

        try {
            unset($range[0]);
            $this->fail();
        } catch(ReadOnlyException $e) {
        }

        $this->assertEquals([0, 0, 0], iterator_to_array($range));
        $this->assertEquals([0, 0, 0], iterator_to_array($range));
    }

    public function testHard()
    {
        $range = new IntExponential(1, 3, 2);
        $this->assertCount(3, $range);
        $this->assertFalse($range->isInfinite());

        $this->assertEquals(1, $range[0]);
        $this->assertEquals(2, $range[1]);
        $this->assertEquals(4, $range[2]);
        $this->checkIsOffsetOutOfRange($range, 3);

        $this->assertEquals(4, $range[-1]);
        $this->assertEquals(2, $range[-2]);
        $this->assertEquals(1, $range[-3]);
        $this->checkIsOffsetOutOfRange($range, -4);

        $this->checkIsOffsetOutOfRange($range, null);
        $this->checkIsOffsetOutOfRange($range, 'test');
        $this->checkIsOffsetOutOfRange($range, '');
        $this->checkIsOffsetOutOfRange($range, 10.5);
        $this->checkIsOffsetOutOfRange($range, '10');

        try {
            $range[0] = 1;
            $this->fail();
        } catch(ReadOnlyException $e) {
        }

        try {
            unset($range[0]);
            $this->fail();
        } catch(ReadOnlyException $e) {
        }

        $this->assertEquals([1, 2, 4], iterator_to_array($range));
        $this->assertEquals([1, 2, 4], iterator_to_array($range));
    }

    public function testInfinite()
    {
        $range = new IntExponential(1, null, 2);
        $this->assertEquals(-1, count($range));
        $this->assertTrue($range->isInfinite());
        $this->assertEquals(1, $range[0]);
        $this->assertEquals(2, $range[1]);
        $this->assertEquals(4, $range[2]);
        $this->assertEquals(8, $range[3]);

        $this->assertEquals(0, $range[-1]);
        $this->assertEquals(0, $range[-2]);
        $this->assertEquals(0, $range[-3]);
        $this->assertEquals(0, $range[-4]);

        $this->checkIsOffsetOutOfRange($range, null);
        $this->checkIsOffsetOutOfRange($range, 'test');
        $this->checkIsOffsetOutOfRange($range, '');
        $this->checkIsOffsetOutOfRange($range, 10.5);
        $this->checkIsOffsetOutOfRange($range, '10');

        $result = [];
        foreach($range as $i => $value) {
            $result[] = $value;
            if($i === 10) {
                break;
            }
        }
        $this->assertEquals([1, 2, 4, 8, 16, 32, 64, 128, 256, 512, 1024], $result);
    }

    protected function checkIsOffsetOutOfRange(IntExponential $range, $offset): void
    {
        try {
            $range[$offset];
            $this->fail();
        } catch(OutOfRangeException $e) {
        }
    }
}
