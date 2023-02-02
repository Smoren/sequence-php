<?php

declare(strict_types=1);

namespace Smoren\Sequence\Tests\Unit;

use Codeception\Test\Unit;

use function Smoren\Sequence\Functions\xrange;
use function Smoren\Sequence\Functions\map;
use function Smoren\Sequence\Functions\filter;
use function Smoren\Sequence\Functions\reduce;

class FunctionsTest extends Unit
{
    /**
     * @dataProvider dataProviderForXrange
     * @param array<int> $config
     * @param array<int> $expected
     * @return void
     */
    public function testXrange(array $config, array $expected): void
    {
        // Given
        $range = xrange(...$config);

        // When
        $result = iterator_to_array($range);

        // Then
        $this->assertEquals($expected, $result);
    }

    /**
     * @return array<array{array<int>, array<int>}>
     */
    public function dataProviderForXrange(): array
    {
        return [
            [
                [10],
                range(0, 9),
            ],
            [
                [0, 10],
                range(0, 9),
            ],
            [
                [2, 10],
                range(2, 11),
            ],
            [
                [2, 3, 3],
                [2, 5, 8],
            ],
            [
                [0],
                [],
            ],
            [
                [0, 0],
                [],
            ],
            [
                [0, 0, 0],
                [],
            ],
            [
                [0, -1],
                [],
            ],
            [
                [0, -1, 0],
                [],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForMap
     * @param iterable $data
     * @param callable $mapper
     * @param array $expected
     * @return void
     */
    public function testMap(iterable $data, callable $mapper, array $expected): void
    {
        // Given
        // When
        $mapped = map($mapper, ...$data);

        // Then
        $this->assertEquals($expected, $mapped->toArray());
    }

    /**
     * @return array<array{array, callable, array}>
     */
    public function dataProviderForMap(): array
    {
        return [
            [
                [],
                static function (array $item) {
                    return $item['name'];
                },
                [],
            ],
            [
                [
                    [],
                ],
                static function (array $item) {
                    return $item['name'];
                },
                [],
            ],
            [
                [
                    [
                        ['name' => 'John'],
                        ['name' => 'Jane'],
                        ['name' => 'Jim'],
                    ],
                ],
                static function (array $item) {
                    return $item['name'];
                },
                ['John', 'Jane', 'Jim'],
            ],
            [
                [
                    [1, 2, 3],
                ],
                static function ($item) {
                    return $item + 1;
                },
                [2, 3, 4],
            ],
            [
                [
                    [1, 2, 3],
                ],
                static function ($item) {
                    return $item;
                },
                [1, 2, 3],
            ],
            [
                [
                    [1, 2, 3],
                ],
                static function () {
                    return null;
                },
                [null, null, null],
            ],
            [
                [
                    [
                        11,
                        22,
                        33,
                    ],
                    [
                        ['name' => 'John'],
                        ['name' => 'Jane'],
                        ['name' => 'Jim'],
                    ],
                ],
                static function (int $id, array $data) {
                    return [$id => $data['name']];
                },
                [[11 => 'John'], [22 => 'Jane'], [33 => 'Jim']],
            ],
            [
                [
                    [
                        11,
                        22,
                        33,
                        44,
                    ],
                    [
                        ['name' => 'John'],
                        ['name' => 'Jane'],
                        ['name' => 'Jim'],
                    ],
                ],
                static function (int $id, array $data) {
                    return [$id => $data['name']];
                },
                [[11 => 'John'], [22 => 'Jane'], [33 => 'Jim']],
            ],
            [
                [
                    [
                        11,
                        22,
                        33,
                    ],
                    [
                        ['name' => 'John'],
                        ['name' => 'Jane'],
                        ['name' => 'Jim'],
                        ['name' => 'Mary'],
                    ],
                ],
                static function (int $id, array $data) {
                    return [$id => $data['name']];
                },
                [[11 => 'John'], [22 => 'Jane'], [33 => 'Jim']],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForFilter
     * @param iterable $data
     * @param callable $mapper
     * @param array $expected
     * @return void
     */
    public function testFilter(iterable $data, callable $mapper, array $expected): void
    {
        // Given
        // When
        $filtered = filter($data, $mapper);

        // Then
        $this->assertEquals($expected, $filtered->toArray());
    }

    /**
     * @return array<array{array, callable, array}>
     */
    public function dataProviderForFilter(): array
    {
        return [
            [
                [],
                static function (array $item) {
                    return $item['value'] > 5;
                },
                [],
            ],
            [
                [
                    ['value' => 1],
                    ['value' => 10],
                    ['value' => 20],
                ],
                static function (array $item) {
                    return $item['value'] > 5;
                },
                [
                    ['value' => 10],
                    ['value' => 20],
                ],
            ],
            [
                [1, 2, 3],
                static function ($item) {
                    return $item > 1;
                },
                [2, 3],
            ],
            [
                [1, 2, 3],
                static function ($item) {
                    return $item > 0;
                },
                [1, 2, 3],
            ],
            [
                [1, 2, 3],
                static function ($item) {
                    return true;
                },
                [1, 2, 3],
            ],
            [
                [1, 2, 3],
                static function () {
                    return false;
                },
                [],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForReduce
     * @param iterable $data
     * @param callable $mapper
     * @param mixed $initialValue
     * @param mixed $expected
     * @return void
     */
    public function testReduce(iterable $data, callable $mapper, $initialValue, $expected): void
    {
        // Given
        // When
        $reduced = reduce($data, $mapper, $initialValue);

        // Then
        $this->assertEquals($expected, $reduced);
    }

    /**
     * @return array<array{array, callable, mixed}>
     */
    public function dataProviderForReduce(): array
    {
        return [
            [
                [],
                static function ($carry, $item) {
                    return $carry + $item;
                },
                null,
                null,
            ],
            [
                [],
                static function ($carry, $item) {
                    return $carry + $item;
                },
                10,
                10,
            ],
            [
                [1, 2, 3],
                static function ($carry, $item) {
                    return $carry + $item;
                },
                0,
                6,
            ],
            [
                [1, 2, 3],
                static function ($carry, $item) {
                    return $carry + $item;
                },
                10,
                16,
            ],
            [
                [1, 2, 3],
                static function ($carry, $item) {
                    return $item;
                },
                10,
                3,
            ],
            [
                [1, 2, 3],
                static function ($carry, $item) {
                    return 0;
                },
                10,
                0,
            ],
        ];
    }
}
