<?php

declare(strict_types=1);

namespace Smoren\Sequence\Structs;

/**
 * {@inheritDoc}
 */
class IntExponential extends IntSequence
{
    /**
     * @param int $index
     * @return int
     */
    public function getValueByIndex(int $index): int
    {
        return (int)($this->start * ($this->step ** $index));
    }

    /**
     * @return int
     */
    public function getStartValue(): int
    {
        return $this->getValueByIndex(0);
    }
}
