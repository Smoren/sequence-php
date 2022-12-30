<?php

declare(strict_types=1);

namespace Smoren\Sequence\Structs;

use Smoren\Sequence\Exceptions\OutOfRangeException;
use Smoren\Sequence\Interfaces\IndexedArrayInterface;
use Smoren\Sequence\Iterators\IndexedArrayIterator;

/**
 * Implementation of Indexed Array.
 *
 * @template T
 * @implements IndexedArrayInterface<T>
 */
class IndexedArray implements IndexedArrayInterface
{
    /**
     * @var array<T> data storage
     */
    protected array $source;

    /**
     * IndexedArray constructor.
     *
     * @param array<T> $source default data storage
     */
    public function __construct(array $source = [])
    {
        $this->source = array_values($source);
    }

    /**
     * {@inheritDoc}
     */
    public function getRange(): Range
    {
        return new Range(0, count($this->source), 1);
    }

    /**
     * {@inheritDoc}
     */
    public function getIterator(): IndexedArrayIterator
    {
        return new IndexedArrayIterator($this);
    }

    /**
     * {@inheritDoc}
     */
    public function offsetExists($offset): bool
    {
        return $this->getRange()->offsetExists($offset);
    }

    /**
     * {@inheritDoc}
     */
    public function offsetGet($offset)
    {
        $index = $this->getRange()->offsetGet($offset);
        return $this->source[$index];
    }

    /**
     * {@inheritDoc}
     */
    public function offsetSet($offset, $value): void
    {
        if($offset === null) {
            $this->source[] = $value;
        } else {
            $range = $this->getRange();
            if(isset($range[$offset])) {
                $index = $range[$offset];
                $this->source[$index] = $value;
            } else {
                throw new OutOfRangeException();
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function offsetUnset($offset): void
    {
        $range = $this->getRange();
        if(isset($range[$offset])) {
            $index = $range[$offset];
            unset($this->source[$index]);
            $this->source = array_values($this->source);
        } else {
            throw new OutOfRangeException();
        }
    }

    /**
     * {@inheritDoc}
     */
    public function count(): int
    {
        return count($this->source);
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return $this->source;
    }
}
