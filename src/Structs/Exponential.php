<?php

declare(strict_types=1);

namespace Smoren\Sequence\Structs;

/**
 * @template T of int|float
 * @extends StepSequence<T>
 */
class Exponential extends StepSequence
{
    /**
     * @param T $start
     * @param int<0, max>|null $size
     * @param T $step
     */
    public function __construct($start, ?int $size, $step)
    {
        parent::__construct($start, $size, $step);
    }

    /**
     * @param int $index
     * @return T
     */
    public function getValueByIndex(int $index)
    {
        return $this->start * ($this->step ** $index);
    }

    /**
     * @param int $previousValue
     * @return T
     */
    public function getNextValue($previousValue)
    {
        return $previousValue * $this->step;
    }
}
