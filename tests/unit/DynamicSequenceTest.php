<?php

declare(strict_types=1);

namespace Smoren\Sequence\Tests\Unit;

use Codeception\Test\Unit;
use Smoren\Sequence\Exceptions\ReadOnlyException;
use Smoren\Sequence\Structs\DynamicSequence;

class DynamicSequenceTest extends Unit
{
    protected const PRECISION = 0.00001;

    /**
     * @dataProvider dataProviderForEqualNonInfinite
     * @param array $config
     * @param callable $nextValueGetter
     * @param callable|null $indexValueGetter
     * @param array $expected
     * @return void
     */
    public function testEqualNonInfinite(
        array $config,
        callable $nextValueGetter,
        ?callable $indexValueGetter,
        array $expected
    ): void {
        // Given
        $sequence = new DynamicSequence(...[...$config, $nextValueGetter, $indexValueGetter]);

        // When
        $result = iterator_to_array($sequence);

        // Then
        $this->assertFalse($sequence->isInfinite());
        $this->assertEqualsWithDelta($expected, $result, self::PRECISION);
        $this->assertEquals(count($sequence), count($expected));

        // iterating and accessing by indexes checks
        $iterationsCount = 0;
        foreach ($sequence as $index => $value) {
            $this->assertEqualsWithDelta($expected[$index], $value, self::PRECISION);
            $this->assertEqualsWithDelta($expected[$index], $sequence[$index], self::PRECISION);

            $negativeIndex = -$index - 1;
            $reverseIndex = count($expected) + $negativeIndex;

            $this->assertEqualsWithDelta($expected[$reverseIndex], $sequence[$negativeIndex], self::PRECISION);
            ++$iterationsCount;
        }

        $this->assertCount($iterationsCount, $expected);

        // readonly checks
        foreach ($sequence as $index => $value) {
            try {
                $sequence[$index] = -1000;
                $this->fail();
            } catch (ReadOnlyException $e) {
                $this->assertEqualsWithDelta($value, $sequence[$index], self::PRECISION);
            }
        }
    }

    /**
     * @return array
     */
    public function dataProviderForEqualNonInfinite(): array
    {
        return [
            [
                [0, 5],
                static function ($previousValue) {
                    return $previousValue;
                },
                static function () {
                    return 0;
                },
                [0, 0, 0, 0, 0]
            ],
            [
                [0, 5],
                static function ($previousValue) {
                    return $previousValue;
                },
                null,
                [0, 0, 0, 0, 0]
            ],
            [
                [0, 5],
                static function ($previousValue) {
                    return $previousValue + 1;
                },
                static function ($index, $start) {
                    return $start + $index;
                },
                [0, 1, 2, 3, 4]
            ],
            [
                [0, 5],
                static function ($previousValue) {
                    return $previousValue + 1;
                },
                null,
                [0, 1, 2, 3, 4]
            ],
            [
                [1, 5],
                static function ($previousValue) {
                    return $previousValue + 1;
                },
                static function ($index, $start) {
                    return $start + $index;
                },
                [1, 2, 3, 4, 5]
            ],
            [
                [1, 5],
                static function ($previousValue) {
                    return $previousValue + 1;
                },
                null,
                [1, 2, 3, 4, 5]
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForInfinite
     * @param array $config
     * @param callable $nextValueGetter
     * @param callable|null $indexValueGetter
     * @param array $expectedDirect
     * @param array $expectedReverse
     * @return void
     */
    public function testInfinite(
        array $config,
        callable $nextValueGetter,
        ?callable $indexValueGetter,
        array $expectedDirect,
        array $expectedReverse
    ): void {
        // Given
        $resultDirect = [];
        $resultReverse = [];
        $range = new DynamicSequence(...[...$config, $nextValueGetter, $indexValueGetter]);

        // When
        foreach ($range as $value) {
            $resultDirect[] = $value;

            if (count($resultDirect) === count($expectedDirect)) {
                break;
            }
        }
        for ($i = 0; $i < count($expectedReverse); ++$i) {
            $resultReverse[] = $range[-$i - 1];
        }

        // Then
        $this->assertTrue($range->isInfinite());
        $this->assertEqualsWithDelta($expectedDirect, $resultDirect, self::PRECISION);
        $this->assertEqualsWithDelta($expectedReverse, $resultReverse, self::PRECISION);
    }

    /**
     * @return array
     */
    public function dataProviderForInfinite(): array
    {
        return [
            [
                [22, null],
                static function ($previousValue) {
                    return $previousValue;
                },
                static function ($index, $startValue) {
                    return $startValue;
                },
                array_fill(0, 100, 22),
                array_fill(0, 100, 22),
            ],
            [
                [0, null],
                static function ($previousValue) {
                    return $previousValue + 1;
                },
                static function ($index, $startValue) {
                    return $startValue + $index;
                },
                range(0, 99, 1),
                range(-1, -100, 1.0),
            ],
        ];
    }
}
