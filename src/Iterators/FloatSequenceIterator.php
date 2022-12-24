<?php

declare(strict_types=1);

namespace Smoren\Sequence\Iterators;

use Smoren\Sequence\Interfaces\SequenceIteratorInterface;
use Smoren\Sequence\Structs\FloatSequence;
use Smoren\Sequence\Traits\SequenceIteratorTrait;

/**
 * @implements SequenceIteratorInterface<float>
 */
class FloatSequenceIterator implements SequenceIteratorInterface
{
    use SequenceIteratorTrait;

    /**
     * @var FloatSequence
     */
    protected FloatSequence $sequence;
    /**
     * @var int
     */
    protected int $currentIndex;

    /**
     * @param FloatSequence $range
     */
    public function __construct(FloatSequence $range)
    {
        $this->sequence = $range;
        $this->currentIndex = 0;
    }

    /**
     * {@inheritDoc}
     * @return float
     */
    public function current(): float
    {
        return $this->sequence[$this->currentIndex];
    }
}
