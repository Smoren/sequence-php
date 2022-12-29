<?php

declare(strict_types=1);

namespace Smoren\Sequence\Iterators;

use Smoren\Sequence\Interfaces\SequenceInterface;
use Smoren\Sequence\Interfaces\SequenceIteratorInterface;

/**
 * @template T
 * @implements SequenceIteratorInterface<T>
 */
class SequenceIterator implements SequenceIteratorInterface
{
    /**
     * @var SequenceInterface<T>
     */
    protected SequenceInterface $sequence;
    /**
     * @var int
     */
    protected int $currentIndex;
    /**
     * @var T
     */
    protected $currentValue;

    /**
     * @param SequenceInterface<T> $sequence
     */
    public function __construct(SequenceInterface $sequence)
    {
        $this->sequence = $sequence;
        $this->currentIndex = 0;
    }

    /**
     * {@inheritDoc}
     * @return T
     */
    public function current()
    {
        return $this->currentValue;
    }

    /**
     * {@inheritDoc}
     */
    public function next(): void
    {
        $this->currentIndex++;
        $this->currentValue = $this->sequence->getNextValue($this->currentValue);
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
        $count = $this->sequence->isInfinite() ? INF : $this->sequence->count();
        return $this->currentIndex >= 0 && $this->currentIndex < $count;
    }

    /**
     * {@inheritDoc}
     */
    public function rewind(): void
    {
        $this->currentIndex = 0;
        $this->currentValue = $this->sequence->getStartValue();
    }
}
