<?php

declare(strict_types=1);

namespace Smoren\Sequence\Structs;

use Smoren\Sequence\Iterators\IntSequenceIterator;
use Smoren\Sequence\Traits\SequenceTrait;
use Smoren\Sequence\Interfaces\SequenceInterface;

/**
 * @implements SequenceInterface<int>
 */
abstract class IntSequence implements SequenceInterface
{
    use SequenceTrait;

    /**
     * @var int
     */
    protected int $start;
    /**
     * @var int<0, max>|null
     */
    protected ?int $size;
    /**
     * @var int
     */
    protected int $step;

    /**
     * @param int $start
     * @param int<0, max>|null $size
     * @param int $step
     */
    public function __construct(int $start, ?int $size, int $step = 1)
    {
        $this->start = $start;
        $this->size = $size;
        $this->step = $step;
    }

    /**
     * @param int $index
     * @return int
     */
    abstract public function getValueByIndex(int $index): int;

    /**
     * {@inheritDoc}
     * @return int
     */
    public function offsetGet($offset): int
    {
        return (int)$this->_offsetGet($offset);
    }

    /**
     * {@inheritDoc}
     */
    public function getIterator(): IntSequenceIterator
    {
        return new IntSequenceIterator($this);
    }
}
