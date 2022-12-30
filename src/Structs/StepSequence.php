<?php

namespace Smoren\Sequence\Structs;

/**
 * Implementation of sequence with constant step.
 *
 * @template T
 * @extends Sequence<T>
 */
abstract class StepSequence extends Sequence
{
    /**
     * @var T step of the sequence
     */
    protected $step;

    /**
     * StepSequence constructor.
     *
     * @param T $start start of the sequence
     * @param int<0, max>|null $size size of the sequence (infinite if null)
     * @param T $step sequence step
     */
    public function __construct($start, ?int $size, $step)
    {
        parent::__construct($start, $size);
        $this->step = $step;
    }
}
