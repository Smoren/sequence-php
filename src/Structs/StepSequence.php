<?php

namespace Smoren\Sequence\Structs;

/**
 * @template T
 * @extends Sequence<T>
 */
abstract class StepSequence extends Sequence
{
    /**
     * @var T
     */
    protected $step;

    /**
     * @param T $start
     * @param int<0, max>|null $size
     * @param T $step
     */
    public function __construct($start, ?int $size, $step)
    {
        parent::__construct($start, $size);
        $this->step = $step;
    }
}
