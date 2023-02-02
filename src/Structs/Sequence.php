<?php

namespace Smoren\Sequence\Structs;

use Smoren\Sequence\Exceptions\OutOfRangeException;
use Smoren\Sequence\Exceptions\ReadOnlyException;
use Smoren\Sequence\Interfaces\SequenceInterface;
use Smoren\Sequence\Interfaces\SequenceIteratorInterface;
use Smoren\Sequence\Iterators\SequenceIterator;

/**
 * Base class for sequences.
 *
 * @template T
 * @implements SequenceInterface<T>
 */
abstract class Sequence implements SequenceInterface
{
    /**
     * @var T start value of the sequence
     */
    protected $start;
    /**
     * @var int<0, max>|null size of the sequence (infinite if null)
     */
    protected ?int $size;

    /**
     * Sequence constructor.
     *
     * @param T $start
     * @param int<0, max>|null $size
     */
    public function __construct($start, ?int $size)
    {
        $this->start = $start;
        $this->size = $size;
    }

    /**
     * {@inheritDoc}
     */
    public function offsetExists($offset): bool
    {
        if (!is_int($offset)) {
            return false;
        }

        if (!$this->isInfinite()) {
            if ($offset >= 0) {
                return $offset < count($this);
            }
            return abs($offset) <= count($this);
        }

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function offsetSet($offset, $value): void
    {
        throw new ReadOnlyException();
    }

    /**
     * {@inheritDoc}
     */
    public function offsetUnset($offset): void
    {
        throw new ReadOnlyException();
    }

    /**
     * {@inheritDoc}
     */
    public function count(): int
    {
        return $this->size ?? -1;
    }

    /**
     * {@inheritDoc}
     */
    public function isInfinite(): bool
    {
        return $this->size === null;
    }

    /**
     * {@inheritDoc}
     */
    public function getStartValue()
    {
        return $this->getValueByIndex(0);
    }

    /**
     * {@inheritDoc}
     */
    public function offsetGet($offset)
    {
        if (!$this->offsetExists($offset)) {
            throw new OutOfRangeException();
        }

        /** @var int $offset */

        if ($this->isInfinite()) {
            return $this->getValueByIndex($offset);
        }

        if ($offset < 0) {
            $offset = $this->size + ($offset % $this->size);
        }

        $offset = ($offset % $this->size);

        return $this->getValueByIndex($offset);
    }

    /**
     * {@inheritDoc}
     */
    public function getIterator(): SequenceIteratorInterface
    {
        return new SequenceIterator($this);
    }
}
