<?php

declare(strict_types=1);

namespace Smoren\Sequence\Structs;

use Smoren\Sequence\Traits\SequenceTrait;

/**
 * {@inheritDoc}
 */
class FloatExponential extends FloatSequence
{
    use SequenceTrait;

    /**
     * @param int $index
     * @return float
     */
    public function getValueByIndex(int $index): float
    {
        return $this->start * ($this->step ** $index);
    }

    /**
     * @return float
     */
    public function getStartValue(): float
    {
        return $this->getValueByIndex(0);
    }
}
