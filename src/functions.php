<?php

namespace Smoren\Sequence\Functions;

use Smoren\Sequence\Structs\Range;

/**
 * Creates iterable range.
 *
 * If size is null then range is infinite.
 *
 * @param int $start start value
 * @param int<0, max>|null $size size of elements (infinite if null)
 * @param int $step range step
 * @return Range<int>
 */
function xrange(int $start, ?int $size = null, int $step = 1): Range
{
    if($size === null) {
        [$start, $size] = [0, $start];
    }

    return new Range($start, $size, $step);
}
