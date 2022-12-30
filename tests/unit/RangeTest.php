<?php

declare(strict_types=1);

namespace Smoren\Sequence\Tests\Unit;

use Codeception\Test\Unit;
use Smoren\Sequence\Exceptions\OutOfRangeException;
use Smoren\Sequence\Exceptions\ReadOnlyException;
use Smoren\Sequence\Structs\Range;

class RangeTest extends Unit
{
    protected const PRECISION = 0.00001;

    /**
     * @dataProvider dataProviderForEqualNonInfinite
     * @param array{int|float, int, int|float} $config
     * @param array<int|float> $expected
     * @return void
     */
    public function testEqualNonInfinite(array $config, array $expected): void
    {
        // Given
        $range = new Range(...$config);

        // When
        $result = iterator_to_array($range);

        // Then
        $this->assertFalse($range->isInfinite());
        $this->assertEqualsWithDelta($expected, $result, self::PRECISION);
        $this->assertEquals(count($range), count($expected));

        // iterating and accessing by indexes checks
        $iterationsCount = 0;
        foreach($range as $index => $value) {
            $this->assertEqualsWithDelta($expected[$index], $value, self::PRECISION);
            $this->assertEqualsWithDelta($expected[$index], $range[$index], self::PRECISION);

            $negativeIndex = -$index - 1;
            $reverseIndex = count($expected) + $negativeIndex;

            $this->assertEqualsWithDelta($expected[$reverseIndex], $range[$negativeIndex], self::PRECISION);
            ++$iterationsCount;
        }

        $this->assertEquals(count($expected), $iterationsCount);

        // readonly checks
        foreach($range as $index => $value) {
            try {
                $range[$index] = -1000;
                $this->fail();
            } catch(ReadOnlyException $e) {
                $this->assertEqualsWithDelta($value, $range[$index], self::PRECISION);
            }
        }
    }

    /**
     * @return array{array{int|float, int, int|float}, array<int|float>}
     */
    public function dataProviderForEqualNonInfinite(): array
    {
        return [
            [   [0, 0, 0],                  []                  ],
            [   [0, 0, 1],                  []                  ],
            [   [1, 0, 1],                  []                  ],
            [   [0, 1, 1],                  [0]                 ],
            [   [0, 1, 0],                  [0]                 ],
            [   [0, 1, 2],                  [0]                 ],
            [   [1, 1, 2],                  [1]                 ],
            [   [0, 3, 1],                  [0, 1, 2]           ],
            [   [1, 3, 1],                  [1, 2, 3]           ],
            [   [1, 3, 0],                  [1, 1, 1]           ],
            [   [0, 5, 2],                  [0, 2, 4, 6, 8]     ],
            [   [0, 3, -1],                 [0, -1, -2]         ],
            [   [-1, 3, -1],                [-1, -2, -3]        ],
            [   [5.5, 3, 1.1],              [5.5, 6.6, 7.7]     ],
        ];
    }

    /**
     * @dataProvider dataProviderForOutOfRangeNonInfinite
     * @param array{int|float, int, int|float} $config
     * @param array<int|float|mixed> $indexes
     * @return void
     */
    public function testOutOfRangeNonInfinite(array $config, array $indexes): void
    {
        // Given
        $range = new Range(...$config);

        // When
        foreach($indexes as $index) {
            try {
                $range[$index];
                $this->fail();
            } catch(OutOfRangeException $e) {
                // Then
            }
        }
    }

    /**
     * @return array{array{int|float, int, int|float}, array<int|float>}
     */
    public function dataProviderForOutOfRangeNonInfinite(): array
    {
        return [
            [   [0, 0, 0],                  [0, 1, -1, -2]                  ],
            [   [0, 0, 1],                  [0, 1, -1, -2]                  ],
            [   [1, 0, 1],                  [0, 1, -1, -2]                  ],
            [   [0, 1, 1],                  [1, 2, -2, -3]                  ],
            [   [0, 1, 0],                  [1, 2, -2, -3]                  ],
            [   [0, 1, 2],                  [1, 2, -2, -3]                  ],
            [   [1, 1, 2],                  [1, 2, -2, -3]                  ],
            [   [0, 3, 1],                  [3, 4, -4, -5]                  ],
            [   [1, 3, 1],                  [3, 4, -4, -5]                  ],
            [   [1, 3, 0],                  [3, 4, -4, -5]                  ],
            [   [0, 5, 2],                  [5, 6, -6, -7]                  ],
            [   [0, 3, -1],                 [3, 4, -4, -5]                  ],
            [   [-1, 3, -1],                [3, 4, -4, -5]                  ],
            [   [5.5, 3, 1.1],              [3, 4, -4, -5]                  ],
            [   [0, 100, 0],                [100, -101]                     ],
            [   [0, 100, 0],                [null, 'test', '', 10.5, '10']  ],
        ];
    }

    /**
     * @dataProvider dataProviderForInfinite
     * @param array{int|float, null, int|float} $config
     * @param array<int|float> $expectedDirect
     * @param array<int|float> $expectedReverse
     * @return void
     */
    public function testInfinite(array $config, array $expectedDirect, array $expectedReverse): void
    {
        // Given
        $resultDirect = [];
        $resultReverse = [];
        $range = new Range(...$config);

        // When
        foreach($range as $value) {
            $resultDirect[] = $value;

            if(count($resultDirect) === count($expectedDirect)) {
                break;
            }
        }
        for($i=0; $i<count($expectedReverse); ++$i) {
            $resultReverse[] = $range[-$i-1];
        }

        // Then
        $this->assertTrue($range->isInfinite());
        $this->assertEqualsWithDelta($expectedDirect, $resultDirect, self::PRECISION);
        $this->assertEqualsWithDelta($expectedReverse, $resultReverse, self::PRECISION);
    }

    /**
     * @return array{array{int|float, null, int|float}, array<int|float>, array<int|float>}
     */
    public function dataProviderForInfinite(): array
    {
        return [
            [
                [0, null, 1],
                range(0, 99, 1),
                range(-1, -100, -1.0),
            ],
            [
                [0, null, 2],
                range(0, 99, 2),
                range(-2, -100, -2.0),
            ],
            [
                [0, null, 0.1],
                range(0, 9, 0.1),
                range(-0.1, -10, -0.1),
            ],
            [
                [1, null, 0],
                array_fill(0, 100, 1),
                array_fill(0, 100, 1),
            ],
            [
                [0, null, 0],
                array_fill(0, 100, 0),
                array_fill(0, 100, 0),
            ],
            [
                [1.1, null, 0],
                array_fill(0, 100, 1.1),
                array_fill(0, 100, 1.1),
            ],
        ];
    }

    /**
     * @return void
     */
    public function testSimpleScenario(): void
    {
        $range = new Range(1, 3, 2);
        $this->assertCount(3, $range);
        $this->assertFalse($range->isInfinite());

        $this->assertEquals(1, $range[0]);
        $this->assertEquals(3, $range[1]);
        $this->assertEquals(5, $range[2]);
        $this->checkIsOffsetOutOfRange($range, 3);

        $this->assertEquals(5, $range[-1]);
        $this->assertEquals(3, $range[-2]);
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

        $this->assertEquals([1, 3, 5], iterator_to_array($range));
        $this->assertEquals([1, 3, 5], iterator_to_array($range));
    }

    /**
     * @param Range $range
     * @param int|mixed $offset
     * @return void
     */
    protected function checkIsOffsetOutOfRange(Range $range, $offset): void
    {
        try {
            $range[$offset];
            $this->fail();
        } catch(OutOfRangeException $e) {
        }
    }
}
