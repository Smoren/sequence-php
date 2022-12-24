<?php

declare(strict_types=1);

namespace Smoren\Sequence\Interfaces;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use Smoren\Sequence\Exceptions\OutOfRangeException;
use Smoren\Sequence\Iterators\IndexedArrayIterator;
use Smoren\Sequence\Structs\IntRange;

/**
 * @template T
 * @extends ArrayAccess<int, T>
 * @extends IteratorAggregate<int, T>
 */
interface IndexedArrayInterface extends ArrayAccess, Countable, IteratorAggregate
{
    /**
     * @return IntRange
     */
    public function getRange(): IntRange;

    /**
     * @return IndexedArrayIterator<T>
     */
    public function getIterator(): IndexedArrayIterator;

    /**
     * @param int|mixed $offset
     * @return bool
     */
    public function offsetExists($offset): bool;

    /**
     * @param int $offset
     * @return T
     * @throws OutOfRangeException
     */
    #[\ReturnTypeWillChange]
    public function offsetGet($offset);

    /**
     * @param int|null $offset
     * @param T $value
     * @return void
     * @throws OutOfRangeException
     */
    public function offsetSet($offset, $value): void;

    /**
     * @param int|mixed $offset
     * @return void
     * @throws OutOfRangeException
     */
    public function offsetUnset($offset): void;

    /**
     * @return int
     */
    public function count(): int;

    /**
     * @return array<T>
     */
    public function toArray(): array;
}
