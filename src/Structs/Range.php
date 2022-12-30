<?php

declare(strict_types=1);

namespace Smoren\Sequence\Structs;

/**
 * Range sequence.
 *
 * @template T of int|float
 * @extends StepSequence<T>
 */
class Range extends StepSequence
{
    /**
     * Range constructor.
     *
     * @param T $start start of the range
     * @param int<0, max>|null $size size of the range (infinite if null)
     * @param T $step range step
     */
    public function __construct($start, ?int $size, $step)
    {
        parent::__construct($start, $size, $step);
    }

    /**
     * {@inheritDoc}
     */
    public function getValueByIndex(int $index)
    {
        return $this->start + $index * $this->step;
    }

    /**
     * {@inheritDoc}
     */
    public function getNextValue($previousValue)
    {
        return $previousValue + $this->step;
    }
}
