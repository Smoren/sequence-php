<?php

declare(strict_types=1);

namespace Smoren\Sequence\Tests\Unit;

use Codeception\Test\Unit;

use function Smoren\Sequence\Functions\xrange;

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
                range(2, 11)   ,
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
}
