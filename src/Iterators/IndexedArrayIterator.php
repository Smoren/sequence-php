<?php

declare(strict_types=1);

namespace Smoren\Sequence\Iterators;

use Smoren\Sequence\Interfaces\IndexedArrayInterface;
use Smoren\Sequence\Interfaces\SequenceIteratorInterface;

/**
 * @template T
 * @implements SequenceIteratorInterface<IndexedArrayInterface<T>>
 */
class IndexedArrayIterator implements SequenceIteratorInterface
{
    /**
     * @var IndexedArrayInterface<T>
     */
    protected IndexedArrayInterface $array;
    /**
     * @var int
     */
    protected int $currentIndex;

    /**
     * @param IndexedArrayInterface<T> $array
     */
    public function __construct(IndexedArrayInterface $array)
    {
        $this->array = $array;
        $this->currentIndex = 0;
    }

    /**
     * {@inheritDoc}
     * @return mixed
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
