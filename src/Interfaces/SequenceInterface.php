<?php

declare(strict_types=1);

namespace Smoren\Sequence\Interfaces;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use Smoren\Sequence\Exceptions\OutOfRangeException;
use Smoren\Sequence\Exceptions\ReadOnlyException;

/**
 * @template T
 * @extends ArrayAccess<int, T>
 * @extends IteratorAggregate<int, T>
 */
interface SequenceInterface extends ArrayAccess, Countable, IteratorAggregate
{
    /**
     * @return bool
     */
    public function isInfinite(): bool;

    /**
     * @param int|mixed $offset
     * @return bool
     */
    public function offsetExists($offset): bool;

    /**
     * @param int|mixed $offset
     * @return T
     * @throws OutOfRangeException
     */
    #[\ReturnTypeWillChange]
    public function offsetGet($offset);

    /**
     * @param int|null|mixed $offset
     * @param T $value
     * @return void
     * @throws ReadOnlyException
     * @throws OutOfRangeException
     */
    public function offsetSet($offset, $value): void;

    /**
     * @param int|mixed $offset
     * @return void
     * @throws ReadOnlyException
     * @throws OutOfRangeException
     */
    public function offsetUnset($offset): void;

    /**
     * @return int
     */
    public function count(): int;
}
