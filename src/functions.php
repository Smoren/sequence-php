<?php

namespace Smoren\Sequence\Functions;

use Smoren\Sequence\Structs\Range;

/**
 * @param int $start
 * @param int<0, max>|null $size
 * @param int $step
 * @return Range<int>
 */
function xrange(int $start, ?int $size = null, int $step = 1): Range
{
    if($size === null) {
        [$start, $size] = [0, $start];
    }

    return new Range($start, $size, $step);
}
