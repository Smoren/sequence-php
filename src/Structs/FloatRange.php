<?php

declare(strict_types=1);

namespace Smoren\Sequence\Structs;

use Smoren\Sequence\Traits\SequenceTrait;

/**
 * {@inheritDoc}
 */
class FloatRange extends FloatSequence
{
    use SequenceTrait;

    /**
     * @param int $index
     * @return float
     */
    public function getValueByIndex(int $index): float
    {
        return $this->start + $index * $this->step;
    }
}
