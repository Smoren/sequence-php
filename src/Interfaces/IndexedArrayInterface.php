<?php

declare(strict_types=1);

namespace Smoren\Sequence\Interfaces;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use Smoren\Sequence\Exceptions\OutOfRangeException;
use Smoren\Sequence\Iterators\IndexedArrayIterator;
use Smoren\Sequence\Structs\Range;

/**
 * Interface for Indexed Array.
 *
 * Its keys are always an unbroken sequence of natural numbers starting from zero.
 *
 * It is also allowed to access array elements from the end with negative indices.
 *
 * OutOfRangeException will be thrown when trying to access a non-existent index.
 *
 * @template T
 * @extends ArrayAccess<int, T>
 * @extends IteratorAggregate<int, T>
 */
interface IndexedArrayInterface extends ArrayAccess, Countable, IteratorAggregate
{
    /**
     * Returns a range of array keys.
     *
     * @return Range<int>
     */
    public function getRange(): Range;

    /**
     * Returns iterator for array.
     *
     * @return IndexedArrayIterator<T>
     */
    public function getIterator(): IndexedArrayIterator;

    /**
     * {@inheritDoc}
     *
     * @param int $offset
     *
     * @return bool
     */
    public function offsetExists($offset): bool;

    /**
     * {@inheritDoc}
     *
     * @param int $offset
     *
     * @return T
     *
     * @throws OutOfRangeException if key does not exist in array
     */
    #[\ReturnTypeWillChange]
    public function offsetGet($offset);

    /**
     * {@inheritDoc}
     *
     * @param int|null $offset
     * @param T $value
     *
     * @return void
     *
     * @throws OutOfRangeException if key is not null and does not exist in array
     */
    public function offsetSet($offset, $value): void;

    /**
     * {@inheritDoc}
     *
     * @param int $offset
     *
     * @return void
     *
     * @throws OutOfRangeException if key does not exist in array
     */
    public function offsetUnset($offset): void;

    /**
     * {@inheritDoc}
     */
    public function count(): int;

    /**
     * Converts IndexedArray to PHP array.
     *
     * @return array<T>
     */
    public function toArray(): array;
}
