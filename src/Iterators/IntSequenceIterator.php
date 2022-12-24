<?php

declare(strict_types=1);

namespace Smoren\Sequence\Iterators;

use Smoren\Sequence\Interfaces\SequenceIteratorInterface;
use Smoren\Sequence\Structs\IntSequence;
use Smoren\Sequence\Traits\SequenceIteratorTrait;

/**
 * @implements SequenceIteratorInterface<int>
 */
class IntSequenceIterator implements SequenceIteratorInterface
{
    use SequenceIteratorTrait;

    /**
     * @var IntSequence
     */
    protected IntSequence $sequence;
    /**
     * @var int
     */
    protected int $currentIndex;

    /**
     * @param IntSequence $range
     */
    public function __construct(IntSequence $range)
    {
        $this->sequence = $range;
        $this->currentIndex = 0;
    }

    /**
     * {@inheritDoc}
     * @return int
     */
    public function current(): int
    {
        return $this->sequence[$this->currentIndex];
    }
}
