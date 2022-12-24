<?php

namespace Smoren\Sequence\Functions;

use Smoren\Sequence\Structs\IntRange;

/**
 * @param int $start
 * @param int<0, max>|null $size
 * @param int $step
 * @return IntRange
 */
function xrange(int $start, ?int $size = null, int $step = 1): IntRange
{
    if($size === null) {
        [$start, $size] = [0, $start];
    }

    return new IntRange($start, $size, $step);
}
