<?php

namespace Smoren\Sequence\Structs;

use function Smoren\Sequence\Functions\reduce;
use function Smoren\Sequence\Functions\xrange;

/**
 * Implementation of sequence configured with callables.
 *
 * @template T
 * @extends Sequence<T>
 */
class DynamicSequence extends Sequence
{
    /**
     * @var callable(T $previousValue): T getter for the next value
     */
    protected $nextValueGetter;
    /**
     * @var (callable(int $index, T $start): T)|null getter for the i-th value
     */
    protected $indexValueGetter;

    /**
     * StepSequence constructor.
     *
     * @param T $start start of the sequence
     * @param int<0, max>|null $size size of the sequence (infinite if null)
     * @param callable(T $previousValue): T $nextValueGetter getter for the next value
     * @param (callable(int $index, T $start): T)|null $indexValueGetter getter for the i-th value
     */
    public function __construct(
        $start,
        ?int $size,
        callable $nextValueGetter,
        ?callable $indexValueGetter = null
    ) {
        parent::__construct($start, $size);
        $this->nextValueGetter = $nextValueGetter;
        $this->indexValueGetter = $indexValueGetter;
    }

    /**
     * {@inheritDoc}
     */
    public function getNextValue($previousValue)
    {
        return ($this->nextValueGetter)($previousValue);
    }

    /**
     * {@inheritDoc}
     */
    public function getValueByIndex(int $index)
    {
        if(is_callable($this->indexValueGetter)) {
            return ($this->indexValueGetter)($index, $this->start);
        }

        return reduce(xrange($index), function($carry) {
            return $this->getNextValue($carry);
        }, $this->start);
    }
}
