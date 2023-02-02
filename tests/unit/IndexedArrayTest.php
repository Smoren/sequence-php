<?php

declare(strict_types=1);

namespace Smoren\Sequence\Tests\Unit;

use Codeception\Test\Unit;
use Smoren\Sequence\Exceptions\OutOfRangeException;
use Smoren\Sequence\Interfaces\IndexedArrayInterface;
use Smoren\Sequence\Structs\IndexedArray;

class IndexedArrayTest extends Unit
{
    /**
     * @return void
     */
    public function testRead(): void
    {
        $array = new IndexedArray([10, 20, 30]);
        $this->assertCount(3, $array);
        $this->assertEquals([10, 20, 30], iterator_to_array($array));
        $this->assertEquals([10, 20, 30], $array->toArray());

        $this->assertEquals(10, $array[0]);
        $this->assertEquals(20, $array[1]);
        $this->assertEquals(30, $array[2]);
        $this->checkIsOffsetOutOfRange($array, 3);

        $this->assertEquals(30, $array[-1]);
        $this->assertEquals(20, $array[-2]);
        $this->assertEquals(10, $array[-3]);
        $this->checkIsOffsetOutOfRange($array, -4);
    }

    /**
     * @return void
     */
    public function testAppendAndUnset(): void
    {
        $array = new IndexedArray([10, 20, 30]);
        $this->assertCount(3, $array);
        $this->assertEquals([10, 20, 30], iterator_to_array($array));

        $array[] = 40;
        $this->assertCount(4, $array);
        $this->assertEquals([10, 20, 30, 40], iterator_to_array($array));

        unset($array[0]);
        $this->assertCount(3, $array);
        $this->assertEquals([20, 30, 40], iterator_to_array($array));

        unset($array[0]);
        $this->assertCount(2, $array);
        $this->assertEquals([30, 40], iterator_to_array($array));

        unset($array[1]);
        $this->assertCount(1, $array);
        $this->assertEquals([30], iterator_to_array($array));

        try {
            unset($array[1]);
            $this->fail();
        } catch (OutOfRangeException $e) {
        }

        unset($array[0]);
        $this->assertCount(0, $array);
        $this->assertEquals([], iterator_to_array($array));

        try {
            unset($array[0]);
            $this->fail();
        } catch (OutOfRangeException $e) {
        }

        $array[] = 1;
        $array[] = 2;
        $array[] = 3;
        $this->assertCount(3, $array);
        $this->assertEquals([1, 2, 3], iterator_to_array($array));

        unset($array[-1]);
        $this->assertCount(2, $array);
        $this->assertEquals([1, 2], iterator_to_array($array));

        unset($array[0]);
        $this->assertCount(1, $array);
        $this->assertEquals([2], iterator_to_array($array));

        unset($array[-1]);
        $this->assertCount(0, $array);
        $this->assertEquals([], iterator_to_array($array));
    }

    /**
     * @return void
     */
    public function testUpdate(): void
    {
        $array = new IndexedArray([10, 20, 30]);
        $this->assertCount(3, $array);
        $this->assertEquals([10, 20, 30], iterator_to_array($array));

        $array[0] = 11;
        $array[1] += 2;
        $array[-1] += 3;
        $this->assertCount(3, $array);
        $this->assertEquals([11, 22, 33], iterator_to_array($array));

        try {
            $array[3] = 100;
            $this->fail();
        } catch (OutOfRangeException $e) {
        }

        try {
            $array[-4] = 100;
            $this->fail();
        } catch (OutOfRangeException $e) {
        }

        $this->assertCount(3, $array);
        $this->assertEquals([11, 22, 33], iterator_to_array($array));
    }

    /**
     * @param IndexedArrayInterface $array
     * @param int|mixed $offset
     * @return void
     */
    protected function checkIsOffsetOutOfRange(IndexedArrayInterface $array, $offset): void
    {
        try {
            $array[$offset];
            $this->fail();
        } catch (OutOfRangeException $e) {
        }
    }
}
