<?php

declare(strict_types=1);

namespace Smoren\Sequence\Tests\Unit;

use Codeception\Test\Unit;

use Smoren\Sequence\Components\Pipe;
use function Smoren\Sequence\Functions\xrange;
use function Smoren\Sequence\Functions\map;
use function Smoren\Sequence\Functions\filter;
use function Smoren\Sequence\Functions\reduce;

class PipeTest extends Unit
{
    /**
     * @dataProvider dataProviderForPipe
     * @param mixed $input
     * @param array<callable> $funcs
     * @param mixed $expected
     * @return void
     */
    public function testPipe($input, array $funcs, $expected): void
    {
        // Given
        $pipe = new Pipe();

        // When
        foreach ($funcs as $func) {
            $pipe[] = $func;
        }

        // Then
        $this->assertEquals($expected, $pipe($input));
    }

    public function dataProviderForPipe(): array
    {
        return [
            [
                1,
                [
                    fn ($x) => $x + 1,
                    fn ($x) => $x ** 2,
                    fn ($x) => -$x,
                ],
                -4,
            ],
        ];
    }
}
