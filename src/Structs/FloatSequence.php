<?php

declare(strict_types=1);

namespace Smoren\Sequence\Structs;

use Smoren\Sequence\Iterators\FloatSequenceIterator;
use Smoren\Sequence\Traits\SequenceTrait;
use Smoren\Sequence\Interfaces\SequenceInterface;

/**
 * @implements SequenceInterface<float>
 */
abstract class FloatSequence implements SequenceInterface
{
    use SequenceTrait;

    /**
     * @var float
     */
    protected float $start;
    /**
     * @var int<0, max>|null
     */
    protected ?int $size;
    /**
     * @var float
     */
    protected float $step;

    /**
     * @param float $start
     * @param int<0, max>|null $size
     * @param float $step
     */
    public function __construct(float $start, ?int $size, float $step = 1)
    {
        $this->start = $start;
        $this->size = $size;
        $this->step = $step;
    }

    /**
     * @param int $index
     * @return float
     */
    abstract public function getValueByIndex(int $index): float;

    /**
     * @return float
     */
    public function getStartValue(): float
    {
        return $this->getValueByIndex(0);
    }

    /**
     * {@inheritDoc}
     * @return float
     */
    public function offsetGet($offset): float
    {
        return $this->_offsetGet($offset);
    }

    /**
     * {@inheritDoc}
     */
    public function getIterator(): FloatSequenceIterator
    {
        return new FloatSequenceIterator($this);
    }
}
