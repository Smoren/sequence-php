<?php

declare(strict_types=1);

namespace Smoren\Sequence\Iterators;

use Smoren\Sequence\Interfaces\IndexedArrayInterface;
use Smoren\Sequence\Interfaces\SequenceIteratorInterface;

/**
 * Iterator implementation for IndexedArray.
 *
 * @template T
 * @implements SequenceIteratorInterface<T>
 */
class IndexedArrayIterator implements SequenceIteratorInterface
{
    /**
     * @var IndexedArrayInterface<T> indexed array for iterating
     */
    protected IndexedArrayInterface $array;
    /**
     * @var int current iteration index
     */
    protected int $currentIndex;

    /**
     * IndexedArrayIterator constructor.
     *
     * @param IndexedArrayInterface<T> $array indexed array to iterate
     */
    public function __construct(IndexedArrayInterface $array)
    {
        $this->array = $array;
        $this->currentIndex = 0;
    }

    /**
     * {@inheritDoc}
     */
    public function current()
    {
        return $this->array[$this->currentIndex];
    }

    /**
     * {@inheritDoc}
     */
    public function next(): void
    {
        $this->currentIndex++;
    }

    /**
     * {@inheritDoc}
     */
    public function key(): int
    {
        return $this->currentIndex;
    }

    /**
     * {@inheritDoc}
     */
    public function valid(): bool
    {
        return isset($this->array[$this->currentIndex]);
    }

    /**
     * {@inheritDoc}
     */
    public function rewind(): void
    {
        $this->currentIndex = 0;
    }
}
