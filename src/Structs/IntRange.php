<?php

declare(strict_types=1);

namespace Smoren\Sequence\Structs;

use Smoren\Sequence\Traits\SequenceTrait;

/**
 * {@inheritDoc}
 */
class IntRange extends IntSequence
{
    use SequenceTrait;

    /**
     * @param int $index
     * @return int
     */
    public function getValueByIndex(int $index): int
    {
        return $this->start + $index * $this->step;
    }
}
