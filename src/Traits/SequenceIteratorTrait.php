<?php

declare(strict_types=1);

namespace Smoren\Sequence\Traits;

use Smoren\Sequence\Interfaces\SequenceInterface;
use Smoren\Sequence\Interfaces\SequenceIteratorInterface;

/**
 * @template T
 * @implements SequenceIteratorInterface<T>
 * @property SequenceInterface<T> $sequence
 * @property int $currentIndex
 */
trait SequenceIteratorTrait
{
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
        $count = $this->sequence->isInfinite() ? INF : $this->sequence->count();
        return $this->currentIndex >= 0 && $this->currentIndex < $count;
    }

    /**
     * {@inheritDoc}
     */
    public function rewind(): void
    {
        $this->currentIndex = 0;
    }
}
