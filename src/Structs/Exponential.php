<?php

declare(strict_types=1);

namespace Smoren\Sequence\Structs;

/**
 * Exponential sequence.
 *
 * @template T of int|float
 * @extends StepSequence<T>
 */
class Exponential extends StepSequence
{
    /**
     * Exponential constructor.
     *
     * @param T $start start of the sequence
     * @param int<0, max>|null $size size of the sequence (infinite if null)
     * @param T $step sequence step
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
        if ((float)$this->step === 0.0 && $index < 0) {
            throw new \DivisionByZeroError();
        }

        return $this->start * ($this->step ** $index);
    }

    /**
     * {@inheritDoc}
     */
    public function getNextValue($previousValue)
    {
        return $previousValue * $this->step;
    }
}
